<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public $user;

    public function mount()
    {
        $this->user = User::find(request()->route('id'));
    }

    public function render()
    {
        return view('livewire.users.show');
    }
}
