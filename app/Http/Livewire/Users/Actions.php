<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class Actions extends Component
{
    public $model = User::class;
    public $rowId;

    public function mount($rowId, $props = [])
    {
        $this->rowId = $rowId;
    }

    public function edit()
    {
       $this->redirect(route('users.form', ['edit', $this->rowId]));
    }

    public function show()
    {
        $this->redirect(route('users.show', $this->rowId));
    }

    public function delete()
    {
        $this->model::destroy($this->rowId);
        $this->emit('refreshLivewireDatatable');

        session()->flash('toast', ['icon' => 'success', 'message' => 'Item Deleted Successfully']);
    }

    public function render()
    {
        return view('livewire.users.actions');
    }
}
