<?php

namespace App\Http\Livewire\Users;

use App\Models\Role;
use App\Models\TimeTable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    protected $model = User::class;
    public $props = [
        'f_name',
        'l_name',
        'ref_no',
        'email',
        'phone',
        'password',
        'office_no',
        'office_hours_start',
        'office_hours_end',
        'role_id',
        'department_id',
        'position',
        'active',
    ];
    public $files = [
        'avatar' => '',
    ];

    public $timetables;

    public $newtimetable = [
        'course_id' => '',
        'day' => '',
        'class_no' => '',
        'time_start' => '',
        'time_end' => '',
    ];

    public $title;
    public $editing;

    protected function rules(): array
    {
        return [
            'props.f_name' => [
                'required',
                'string'
            ],
            'props.l_name' => [
                'required',
                'string'
            ],
            'props.email' => [
                'required',
                'email',
                Rule::unique((new $this->model)->getTable(), 'email')->ignore($this->editing->id ?? ":id")
            ],
            'props.phone' => [
                'required',
                'string',
                Rule::unique((new $this->model)->getTable(), 'phone')->ignore($this->editing->id ?? ":id")
            ],
            'props.password' => [
                'sometimes',
                'confirmed',
                Password::min(8)
            ],
            'props.office_no' => [
                'nullable',
                'string',
                Rule::unique((new $this->model)->getTable(), 'office_no')->ignore($this->editing->id ?? ":id")
            ],
            'props.office_hours_start' => [
                'nullable',
                'string',
            ],
            'props.office_hours_end' => [
                'nullable',
                'string',
            ],
            'props.role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id'),
            ],
            'props.department_id' => [
                'nullable',
                'integer',
                Rule::exists('departments', 'id'),
            ],
            'props.position' => [
                'nullable',
                'string',
            ],
            'files.avatar' => [
                'nullable',
            ],
        ];
    }

    public function mount()
    {
        $rowId = request()->route('id');
        if ($rowId) {
            $this->setEditing($rowId);
            $this->timetables = $this->editing->timeTable()->orderBy('day')->get()->toArray();
        }
        $this->setTitle(request()->route('process'));
    }

    /*
     * Functions
     */
    public function submit()
    {
        if ($this->editing && !$this->props['password']) {
            $this->validate(Arr::except($this->rules(), ['props.password']));
        } else {
            $this->validate();
        }

        \DB::beginTransaction();
        try {
            $this->saveAndRedirect();
        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('toast', ['icon' => 'success', 'message' => $e->getMessage()]);
        }
    }

    public function addTimeTable()
    {
        $this->validate([
            'newtimetable.course_id' => [
                'required',
                'integer',
                Rule::exists('courses', 'id'),
            ],
            'newtimetable.day' => [
                'required'
            ],
            'newtimetable.class_no' => [
                'required'
            ],
            'newtimetable.time_start' => [
                'required'
            ],
            'newtimetable.time_end' => [
                'required'
            ],
        ]);

        $this->editing->timeTable()->create($this->newtimetable);

        $this->timetables = $this->editing->timeTable()->orderBy('day')->get()->toArray();

        $this->reset(['newtimetable']);


        session()->flash('toast', ['icon' => 'success', 'message' => 'Time Table Added Successfully']);
    }

    public function deleteTimeTable($id)
    {
        TimeTable::where('id', $id)->delete();
        $this->timetables = $this->editing->timeTable()->orderBy('day')->get()->toArray();
        session()->flash('toast', ['icon' => 'success', 'message' => 'Time Table Deleted Successfully']);
    }

    protected function saveAndRedirect($route = 'index')
    {
        $message = __('Member has been added successfully');

        if (count($this->files) > 0) {
            foreach ($this->files as $key => $file) {
                $this->props[$key] = $this->doFileUpload($file, $this->editing->avatar ?? null, 'users');
            }
        }

        $this->beforeCreateOrUpdate();

        if ($this->editing) {
            $message = __('Member has been updated successfully');
            $this->beforeUpdate();
            $this->editing->update($this->props);
            $this->afterUpdate();
        } else {
            $this->beforeCreate();
            $this->model::create($this->props);
            $this->afterCreate();
        }

        \DB::commit();

        session()->flash('toast', ['icon' => 'success', 'message' => $message]);

        $this->redirect(route('dashboard'));
    }

    /*
     * Hooks For Creating and Updating
     */
    private function beforeCreateOrUpdate()// use it to set some action before creating
    {
        if ($this->props['password']) {
            $this->props['password'] = Hash::make($this->props['password']);
        } else {
            unset($this->props['password']);
        }

        if ((!$this->editing) or ($this->editing and $this->props['role_id'] != $this->editing->role_id)) {
            $role = Role::find($this->props['role_id']);
            switch ($role->slug) {
                case Role::ADMIN :
                    $this->props['ref_no'] = 'AD-';
                    break;
                case Role::LECTURER :
                    $this->props['ref_no'] = 'LC-';
                    break;
                case Role::HR :
                    $this->props['ref_no'] = 'HR-';
                    break;
                case Role::STUDENT :
                    $this->props['ref_no'] = 'ST-';
                    break;
            }
            $this->props['ref_no'] .= ($this->editing) ? explode('-', $this->editing->ref_no)[1] : Carbon::now()->timestamp;
        }
    }

    private function beforeCreate() // use it to set some action before creating
    {
    }

    private function beforeUpdate() // use it to set some action before updating
    {
    }

    private function afterCreate() // use it to set some action after creating
    {
    }

    private function afterUpdate()// use it to set some action after creating
    {
    }

    /*
     * End Hooks
     */

    private function doFileUpload($file, $oldFile, $folder, $driver = 'public')
    {
        //check file if is not null and not string (update status) store it and return it
        if ($file) {
            if (is_string($file)) {
                return $file;
            }
            \Storage::disk($driver)->delete($oldFile);
            return $file->store($folder, $driver);
        }
        return null;
    }

    private function setTitle($process)
    {
        switch ($process) {
            case 'create' :
                $this->title = __('Add New Member');
                break;
            case 'edit' :
                $this->title = __('Edit Member') . ' ' . $this->editing->name;
                break;
            default :
                abort(404);
        }

    }

    private function unlinkFile($prop)
    {
        $prop = explode('.', $prop)[1];
        \Storage::disk('public')->delete($this->editing->$prop);
        $this->editing->update([
            $prop => null
        ]);
        $this->files[$prop] = '';
    }

//    protected function validationAttributes(): array
//    {
//        return validation_attributes(); // In Helper File
//    }

    /*
     * Events
     */
    private function setEditing($rowId)
    {
        $this->editing = $this->model::find($rowId);
        $props = array_merge($this->props, array_keys($this->files));
        $this->props = [];
        foreach ($this->editing->only($props) as $key => $value) {
            if (array_key_exists($key, $this->files)) {
                $this->files[$key] = $value;
            } else {
                $this->props[$key] = ($key == 'password') ? '' : $value;
            }
        }
    }

    public function getRolesDropdown()
    {
        $role = auth()->user()->role->slug;

        if ($role == Role::ADMIN) {
            return Role::pluck('name', 'id');
        } elseif ($role == Role::HR) {
            return Role::whereIn('slug', [Role::LECTURER, Role::STUDENT, Role::HR])->pluck('name', 'id');
        } elseif ($role == Role::LECTURER) {
            return Role::where('slug', Role::STUDENT)->pluck('name', 'id');
        } else {
            return null;
        }
    }

    public function render()
    {
        return view('livewire.users.form');
    }
}
