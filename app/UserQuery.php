<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class UserQuery extends Builder
{
    public function findByEmail($email)
    {
        return $this->where(compact('email'))->first();
    }

    public function filterBy(array $filters)
    {
        foreach ($filters as $name => $value) {
            $this->{'filterBy'.Str::studly($name)}($value);
        }

        return $this;
    }

    public function filterBySearch($search)
    {
        if ($search) {
            // $this->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', "%{$search}%")

            $this->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('team', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        }

        return $this;
    }

    public function filterByState($state)
    {
        if ($state == 'active') {
            return $this->where('active', true);
        }

        if ($state == 'inactive') {
            return $this->where('active', false);
        }
        return $this;
    }

    public function filterByRole($role) {
        if (in_array($role, ['admin', 'user'])) {
            $this->where('role', $role);
        }

        return $this;
    }


}
