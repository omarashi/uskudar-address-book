<x-slot name="header">
    {{ __('Dashboard') }}
</x-slot>
@if(auth()->user()->role->slug != \App\Models\Role::STUDENT)
    <x-slot name="buttons">
        <a href="{{ route('users.form', 'create') }}"
           class="p-2 rounded bg-teal-600 text-white hover:bg-teal-400 mr-1">
            <i class="bx bx-plus-circle"></i> {{ __('Add New') }}
        </a>
    </x-slot>
@endif
<div>
    <div class="p-8">
        <livewire:users.datatable/>
    </div>
</div>
