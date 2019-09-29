<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserFilter extends QueryFilter
{
    protected $aliases = [
        'date' => 'created_at',
    ];

    public function rules(): array
    {
        return [
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:admin,user',
            'skills' => 'array|exists:skills,id',
            'from' => 'date_format:d/m/Y',
            'to' => 'date_format:d/m/Y',
            'order' => 'in:name,email,date,name-desc,email-desc,date-desc',
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
        if (Str::endsWith($value, '-desc')) {
            $field = Str::substr($value, 0, -5);

            if ($field == 'name') {
                $query->orderByRaw('CONCAT(first_name, " ", last_name) DESC');
            } else {
                $query->orderByDesc($this->getColumnName($field));
            }
        } elseif ($value == 'name') {
            $query->orderByRaw('CONCAT(first_name, " ", last_name) ASC');
        } else {
            $query->orderBy($this->getColumnName($value));
        }
    }

    protected function getColumnName($alias)
    {
        return $this->aliases[$alias] ?? $alias;
    }
}
