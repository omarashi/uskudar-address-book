<x-slot name="header">
    {{ $title }}
</x-slot>

<x-slot name="buttons">
    @if(request()->route('process') == 'edit')
        <a href="{{ route('users.show', $editing->id) }}"
           class="p-2 rounded bg-blue-500 text-white hover:bg-blue-300 mr-1">
            <i class="bx bx-show"></i> {{ __('Show Member') }}
        </a>
    @endif
    <a href="{{ route('dashboard') }}"
       class="p-2 rounded bg-yellow-500 text-white hover:bg-yellow-300 mr-1">
        <i class="bx bx-left-arrow-circle"></i> {{ __('Back') }}
    </a>
</x-slot>
<div class="w-3/4 mx-auto mt-10 mb-20">
    @if(session()->has('toast') and session('toast')['icon'] == 'error')
        <div class="alert alert-error mb-5">
            {{ session('toast')['message'] }}
        </div>
    @endif

    <div class="bg-white py-6 px-4 border-gray-100 border-2">
        <form wire:submit.prevent="submit()" method="POST"
              x-data="{ password: '', password_confirmation: '', role_id: '{{ $this->props['role_id'] ?? '' }}' }">
            <div class="flex justify-center items-center flex-col">
                <x-forms.avatar name="avatar" label="{{ __('Avatar') }}"
                                :image="$files['avatar']"
                                class="inline-flex"></x-forms.avatar>
                <x-forms.toggle name="active" label="{{ __('Active') }}"
                                class="flex items-center justify-center mt-10 mb-4"></x-forms.toggle>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <x-forms.input class="mt-3" name="f_name" type="text"
                               label="{{ __('First Name') }}"
                               validate="true"></x-forms.input>
                <x-forms.input class="mt-3" name="l_name" type="text"
                               label="{{ __('Last Name') }}"
                               validate="true"></x-forms.input>
                <x-forms.input class="mt-3" name="email" type="email"
                               label="{{ __('Email Address') }}"
                               validate="true"></x-forms.input>
                <x-forms.input class="mt-3" name="phone" type="tel"
                               label="{{ __('Phone Number') }}"
                               validate="true"></x-forms.input>
                <x-forms.input class="mt-3" name="password" type="password"
                               x-model="password"
                               label="{{ (request()->route('process') == 'edit') ? 'Password ( Leave empty for same password )' : 'Password'  }}"
                               validate="true"></x-forms.input>
                <x-forms.input class="mt-3" name="password_confirmation" type="password"
                               x-model="password_confirmation"
                               label="{{ __('Confirm Password') }}"
                               validate="true"></x-forms.input>

                <div class="flex justify-center items-center py-1">
                    <div
                        :class="{'bg-green-200 text-green-700': password.length > 7, 'bg-red-200 text-red-700':password.length < 7 }"
                        class=" rounded-full p-1 fill-current ">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="password.length > 7" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                            <path x-show="password.length < 7" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>

                        </svg>
                    </div>
                    <span :class="{'text-green-700': password.length > 7, 'text-red-700':password.length < 7 }"
                          class="font-medium text-sm ml-3"
                          x-text="password.length > 7 ? 'The minimum length is reached' : 'At least 8 characters required' "></span>
                </div>
                <div class="flex justify-center items-center py-1">
                    <div
                        :class="{'bg-green-200 text-green-700': password == password_confirmation && password.length > 0, 'bg-red-200 text-red-700':password != password_confirmation || password.length == 0}"
                        class=" rounded-full p-1 fill-current ">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="password == password_confirmation && password.length > 0"
                                  stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                            <path x-show="password != password_confirmation || password.length == 0"
                                  stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>

                        </svg>
                    </div>
                    <span
                        :class="{'text-green-700': password == password_confirmation && password.length > 0, 'text-red-700':password != password_confirmation || password.length == 0}"
                        class="font-medium text-sm ml-3"
                        x-text="password == password_confirmation && password.length > 0 ? 'Passwords match' : 'Passwords do not match' "></span>
                </div>

            </div>
            <div class="grid grid-cols-3 gap-4">
                @if(in_array(auth()->user()->role->slug, [ \App\Models\Role::ADMIN, \App\Models\Role::HR ]))
                    <x-forms.select class="mt-3" name="role_id" label="{{ __('Role') }}"
                                    validate="true" x-model="role_id"
                                    :options="$this->getRolesDropdown()"></x-forms.select>
                    <x-forms.select class="mt-3" name="department_id" label="{{ __('Department') }}"
                                    validate="true"
                                    :options="\App\Models\Department::pluck('name', 'id')"></x-forms.select>
                    <x-forms.input class="mt-3" name="position" type="text"
                                   label="{{ __('Position') }}"
                                   validate="true"></x-forms.input>
                @else
                    <x-forms.select class="mt-3" name="role_id" label="{{ __('Role') }}"
                                    validate="true" x-model="role_id"
                                    :options="\App\Models\Role::where('slug', auth()->user()->role->slug)->pluck('name','id')"
                                    disabled="true"></x-forms.select>
                    <x-forms.select class="mt-3" name="department_id" label="{{ __('Department') }}"
                                    validate="true"
                                    :options="\App\Models\Department::pluck('name', 'id')"
                                    disabled="true"></x-forms.select>
                    <x-forms.input class="mt-3" name="position" type="text"
                                   label="{{ __('Position') }}"
                                   validate="true" disabled="true"></x-forms.input>
                @endif
                @if(auth()->user()->role->slug != \App\Models\Role::STUDENT)
                    <x-forms.input class="mt-3" name="office_no" type="text"
                                   label="{{ __('Office No.') }}"
                                   validate="true"></x-forms.input>

                    <x-forms.input class="mt-3" name="office_hours_start" type="time"
                                   label="{{ __('Office Hours From') }}"
                                   validate="true"></x-forms.input>
                    <x-forms.input class="mt-3" name="office_hours_end" type="time"
                                   label="{{ __('Office Hours To') }}"
                                   validate="true"></x-forms.input>
                @endif
            </div>


            <div
                x-show="role_id == '{{ \App\Models\Role::where('slug', \App\Models\Role::LECTURER)->first()->id }}'">
                <div
                    class="flex mt-10 sticky top-0 bg-white py-3 border-b-2 @if(request()->route('process') == 'create') hidden @endif ">
                    <h2 class="font-semibold text-2xl mr-auto">Time Table</h2>
                </div>
                @if($timetables)
                    @foreach ($timetables as $index => $timetable)
                        <div class="grid grid-cols-6 gap-2 mt-4 place-items-center">
                            <input type="hidden" wire:model.defer="timetables.{{$index}}.id">
                            <x-forms.select class="mt-3" name="timetables.{{$index}}.course_id"
                                            label="{{ __('Course Name') }}"
                                            validate="true"
                                            :options="\App\Models\Course::pluck('name','id')"></x-forms.select>
                            <x-forms.select class="mt-3" name="timetables.{{$index}}.day" label="{{ __('Day') }}"
                                            validate="true" :options="\App\Models\TimeTable::$days"></x-forms.select>
                            <x-forms.input class="mt-3" name="timetables.{{$index}}.class_no" type="text"
                                           label="{{ __('Class No.') }}"
                                           validate="true"></x-forms.input>
                            <x-forms.input class="mt-3" name="timetables.{{$index}}.time_start" type="time"
                                           label="{{ __('Time From') }}"
                                           validate="true"></x-forms.input>
                            <x-forms.input class="mt-3" name="timetables.{{$index}}.time_end" type="time"
                                           label="{{ __('Time To') }}"
                                           validate="true"></x-forms.input>
                            <button type="button"
                                    class="mt-8 p-2 h-10 rounded shadow bg-red-500 text-white hover:bg-red-300"
                                    wire:click="deleteTimeTable({{ $timetable['id'] }})">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    @endforeach
                @endif
                <div class="grid grid-cols-6 gap-2 mt-4 @if(request()->route('process') == 'create') hidden @endif">
                    <x-forms.select class="mt-3" name="newtimetable.course_id"
                                    label="{{ __('Course Name') }}"
                                    validate="true"
                                    :options="\App\Models\Course::pluck('name','id')"></x-forms.select>
                    <x-forms.select class="mt-3" name="newtimetable.day" label="{{ __('Day') }}"
                                    validate="true" :options="\App\Models\TimeTable::$days"></x-forms.select>
                    <x-forms.input class="mt-3" name="newtimetable.class_no" type="text"
                                   label="{{ __('Class No.') }}"
                                   validate="true"></x-forms.input>
                    <x-forms.input class="mt-3" name="newtimetable.time_start" type="time"
                                   label="{{ __('Time From') }}"
                                   validate="true"></x-forms.input>
                    <x-forms.input class="mt-3" name="newtimetable.time_end" type="time"
                                   label="{{ __('Time To') }}"
                                   validate="true"></x-forms.input>
                    <button type="button"
                            class="mt-10 p-2 h-10 rounded shadow bg-yellow-500 text-white hover:bg-yellow-300"
                            wire:click="addTimeTable()">Add Time Table
                    </button>
                </div>
            </div>
            <div class="text-center mt-10">
                <button class="w-36 h-10 bg-teal-600 hover:bg-teal-400 text-white rounded shadow" type="submit">
                    {{ __('Submit')}}
                </button>
            </div>
        </form>
    </div>
</div>
