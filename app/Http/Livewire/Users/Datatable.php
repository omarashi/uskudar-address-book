<?php

namespace App\Http\Livewire\Users;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Livewire;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Datatable extends LivewireDatatable
{
    public $hideable = 'select';
    public $exportable = false;
    public $complex = false;
    public $persistComplexQuery = false;
    public $persistFilters = false;

    public $role = Role::LECTURER;

    public function builder()
    {
        return User::whereHas('role', function ($query) {
            return $query->where('slug', $this->role);
        })->where('users.id', '<>', auth()->id())->leftJoin('departments', 'departments.id', 'users.department_id');
    }

    public function columns()
    {
        return [
            Column::checkbox(),

            Column::callback('avatar', function ($avatar) {
                if (!$avatar) {
                    $url = 'https://via.placeholder.com/240x240';
                } else {
                    $url = asset('storage/' . $avatar);
                }
                return '<img src="' . $url . '" class="profile-pic" />';
            })
                ->label('Avatar')
                ->contentAlignCenter()
                ->unsortable(),

            Column::callback(['f_name', 'l_name'], function ($f_name, $l_name) {
                return ucwords($f_name . ' ' . $l_name);
            })
                ->label('name')
                ->searchable()
                ->filterable(),

            Column::name('department.name')
                ->label('Department')
                ->searchable()
                ->filterable(Department::pluck('name')),

            Column::name('ref_no')
                ->label('Reference No.')
                ->searchable()
                ->filterable(),

            Column::name('email')
                ->label('Email')
                ->searchable()
                ->filterable(),

            Column::name('phone')
                ->label('Phone')
                ->searchable()
                ->filterable(),

            Column::name('office_no')
                ->label('Office')
                ->searchable()
                ->filterable(),

            Column::callback(['office_hours_start', 'office_hours_end'], function ($start, $end) {
                if (!$start or !$end)
                    return null;
                return Carbon::make($start)->format('H:i') . ' - ' . Carbon::make($end)->format('H:i');
            })
                ->label('Office Hours')
                ->searchable()
                ->filterable(),

            BooleanColumn::name('active')
                ->label('Active')
                ->filterable(),

            Column::callback(['id'], function ($id) {
                return Livewire::mount('users.actions', [
                    'rowId' => $id
                ])->html();
            })
                ->label('Actions')
                ->unsortable()
        ];
    }

    public function getRolesDropdown()
    {
        $role = auth()->user()->role->slug;
        $query = Role::query();
        switch ($role) {
            case Role::LECTURER :
                $query->where('slug', Role::STUDENT);
                break;
            case Role::HR :
                $query->whereIn('slug', [Role::LECTURER, Role::STUDENT]);
                break;
            case Role::STUDENT :
                $query->where('slug', Role::LECTURER);
                break;
        }
        return $query->pluck('name', 'slug');
    }
}
