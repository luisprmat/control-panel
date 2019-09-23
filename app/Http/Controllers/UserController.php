<?php

namespace App\Http\Controllers;

use App\{User, UserProfile, Profession, Skill};
use App\Http\Requests\{CreateUserRequest, UpdateUserRequest};

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->with('team', 'skills', 'profile.profession')
            ->byState(request('state'))
            ->search(request('search'))
            ->orderByDesc('created_at')
            ->paginate();

        $users->appends(request(['search']));

        return view('users.index', [
            'users' => $users,
            'title' => 'Listado de usuarios',
            'roles' => trans('users.filters.roles'),
            'skills' => Skill::orderBy('name')->get(),
            'states' => trans('users.filters.states'),
            'checkedSkills' => collect(request('skills')),
        ]);
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
