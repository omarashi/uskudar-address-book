<div class="flex justify-center items-center space-x-2">
    <button type="button" wire:click="show()"
            class="p-1 text-yellow-500 rounded hover:bg-yellow-500 hover:text-white">
        <i class="bx bx-show text-xl"></i>
    </button>
    @if(auth()->user()->role->slug != \App\Models\Role::STUDENT)
        <button type="button" wire:click="edit()" class="p-1 text-blue-600 rounded hover:bg-blue-600 hover:text-white">
            <i class="bx bx-edit-alt text-xl"></i>
        </button>
        @include('datatables::delete')
    @endif
</div>
