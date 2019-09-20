<?php

namespace App\Http\Controllers;

use App\{User, UserProfile, Profession, Skill};
use App\Http\Requests\{CreateUserRequest, UpdateUserRequest};

class UserController extends Controller
{
    public function index()
    {
        // $users = User::query()
        //     ->when(request('team'), function ($query, $team) {
        //         if ($team === 'with_team') {
        //             $query->has('team');
        //         } elseif($team === 'without_team') {
        //             $query->doesntHave('team');
        //         }
        //     })
        //     ->with('team') // No funciona con Laravel Scout
        //     ->search(request('search'))
        //     ->orderByDesc('created_at')
        //     ->paginate();

        if (request('search')) {
            $q = User::search(request('search'));
        } else {
            $q = User::query();
        }
        $users = $q->paginate()
            ->appends(request(['search', 'team']));

        $users->load('team');

        $title = 'Listado de usuarios';

        return view('users.index', compact('title', 'users'));
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->paginate();

        $title = 'Listado de usuarios en papelera';

        return view('users.index', compact('title', 'users'));
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    public function create()
    {
        $user = new User;

        return view('users.create', compact('user'));
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);

        return redirect()->route('users.show', ['user' => $user]);
    }

    public function trash(User $user)
    {
        $user->delete();
        $user->profile()->delete();

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();

        $user->forceDelete();

        return redirect()->route('users.trashed');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();

        $user->restore();
        $user->profile()->restore();

        return redirect()->route('users.trashed');
    }
}
