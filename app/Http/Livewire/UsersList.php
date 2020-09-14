<?php

namespace App\Http\Livewire;

use App\Sortable;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Http\Request;
use Livewire\Component;

class UsersList extends Component
{
    public $view;
    public $currentUrl;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function mount($view, Request $request)
    {
        $this->view = $view;
        $this->currentUrl = $request->url();
        $this->search = $request->input('search');
    }

    protected function getUsers(Sortable $sortable)
    {
        $users = User::query()
            ->with('team', 'skills', 'profile.profession')
            ->withLastLogin()
            ->onlyTrashedIf(request()->routeIs('users.trashed'))
            ->applyFilters([
                'search' => $this->search
            ])
            ->orderByDesc('created_at')
            ->paginate();

        $sortable->appends($users->parameters());

        return $users;
    }

    public function render()
    {
        $sortable = new Sortable($this->currentUrl);

        return view('users._livewire-list', [
            'users' => $this->getUsers($sortable),
            'skills' => Skill::getList(),
            'checkedSkills' => collect(request('skills')),
            'sortable' => $sortable,
        ]);
    }
}
