<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User, UserProfile, Profession, Skill, Sortable, UserFilter};
use App\Http\Requests\{CreateUserRequest, UpdateUserRequest};

class UserController extends Controller
{
    public function index(Request $request, UserFilter $filters, Sortable $sortable)
    {
        $users = User::query()
            ->with('team', 'skills', 'profile.profession')
            ->filterBy($filters, $request->only(['state', 'role', 'search', 'skills', 'from', 'to']))
            ->orderByDesc('created_at')
            ->paginate();

        $users->appends($filters->valid());

        $sortable->setCurrentOrder(request('order'), request('direction'));

        return view('users.index', [
            'users' => $users,
            'view' => 'index',
            'skills' => Skill::orderBy('name')->get(),
            'checkedSkills' => collect(request('skills')),
            'sortable' => $sortable,
        ]);
    }

    public function trashed(Sortable $sortable)
    {
        $users = User::onlyTrashed()
            ->with('team', 'skills', 'profile.profession')
            ->paginate();

        $sortable->setCurrentOrder(request('order'), request('direction'));

        return view('users.index', [
            'users' => $users,
            'view' => 'trash',
            'sortable' => $sortable,
        ]);
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
        return $this->form('users.edit', $user);
    }

    protected function form($view, User $user)
    {
        return view($view, [
            'professions' => Profession::orderBy('title', 'ASC')->get(),
            'skills' => Skill::orderBy('name', 'ASC')->get(),
            'user' => $user,
        ]);
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
