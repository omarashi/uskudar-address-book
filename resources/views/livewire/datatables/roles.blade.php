<div>
    <select name="role" id="dt-role" wire:model.lazy="role" class="border-gray-300 rounded shadow">
        @foreach($this->getRolesDropdown() as $slug => $role)
            <option value="{{ $slug }}"> {{ $role }}</option>
        @endforeach
    </select>
</div>
