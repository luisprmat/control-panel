<?php

namespace App;

use App\Sortable;
use Carbon\Carbon;
use App\Models\Login;
use App\Rules\SortableColumn;
use Illuminate\Support\Facades\DB;

class UserFilter extends QueryFilter
{
    protected $aliases = [
        'date' => 'created_at',
        'login' => 'last_login_at'
    ];

    public function rules(): array
    {
        return [
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:admin,user',
            'skills' => 'array|exists:skills,id',
            'from' => 'filled|date_format:d/m/Y',
            'to' => 'filled|date_format:d/m/Y',
            'order' => [new SortableColumn(['name', 'email', 'date', 'login'])],
        ];
    }

    public function search($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('team', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
            });
        });
    }

    public function state($query, $state)
    {
        return $query->where('active', $state == 'active');
    }

    public function skills($query, $skills)
    {
        $subquery = DB::table('user_skill AS s')
            ->selectRaw('COUNT(`s`.`id`)')
            ->whereColumn('s.user_id', 'users.id')
            ->whereIn('skill_id', $skills);

        $query->addBinding($subquery->getBindings());
        $query->where(DB::raw("({$subquery->toSql()})"), count($skills));
    }

    public function from($query, $date)
    {
        $date = Carbon::createFromFormat('d/m/Y', $date);

        $query->whereDate('created_at', '>=', $date);
    }

    public function to($query, $date)
    {
        $date = Carbon::createFromFormat('d/m/Y', $date);

        $query->whereDate('created_at', '<=', $date);
    }

    public function order($query, $value)
    {
        [$column, $direction] = Sortable::info($value);

        if ($column == 'login') {
            return $query->orderBy(Login::select('logins.created_at')
                ->whereColumn('logins.user_id', 'users.id')
                ->latest() // orderByDesc('created_at')
                ->limit(1), $direction
            );
        }

        if ($column == 'name') {
            $queryRaw = 'CONCAT(first_name, " ", last_name)';
            if ($direction == 'asc') {
                $queryRaw = $queryRaw . ' ASC';
            } else {
                $queryRaw = $queryRaw . ' DESC';
            }
            $query->orderByRaw($queryRaw);
        } else {
            $query->orderBy($this->getColumnName($column), $direction);
        }

    }

    protected function getColumnName($alias)
    {
        return $this->aliases[$alias] ?? $alias;
    }
}
