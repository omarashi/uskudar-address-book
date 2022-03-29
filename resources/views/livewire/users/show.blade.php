<x-slot name="header">
    <h2 class="font-bold text-xl"><span class="text-teal-600">{{ $user->name }}</span> Info</h2>
</x-slot>
<x-slot name="buttons">
    <a href="{{ route('users.form', ['edit', $user->id]) }}"
       class="p-2 rounded bg-blue-500 text-white hover:bg-blue-300 mr-1">
        <i class="bx bx-edit"></i> {{ __('Edit Member') }}
    </a>
    <a href="{{ route('dashboard') }}"
       class="p-2 rounded bg-yellow-500 text-white hover:bg-yellow-300 mr-1">
        <i class="bx bx-left-arrow-circle"></i> {{ __('Back') }}
    </a>
</x-slot>
<div class="w-3/4 mx-auto mt-10 mb-20">
    <div class="bg-white py-6 px-4 border-gray-100 border-2">
        <div class="flex items-center">
            <div
                class="flex justify-center items-center w-32 h-32 mr-auto border rounded-full relative bg-gray-100 shadow-inset">
                <div class="object-cover w-full h-full rounded-full flex justify-center items-center">
                    @if($user->avatar)
                        <img src="{{ asset('storage/'.$user->avatar) }}"
                             class="object-cover w-full h-32 rounded-full">
                    @else
                        <span class="bx bx-image text-gray-500 text-3xl"></span>
                    @endif
                </div>
            </div>
            <div class="mr-40">
                <p class="text-xl text-teal-600"><span
                        class="font-semibold text-gray-600">Status : </span> {{ ($user->active == 1) ? 'Active' : 'Suspended'  }}
                </p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <p class="text-xl text-teal-600 mt-3"><span
                    class="font-semibold text-gray-600">First Name : </span> {{ ucwords($user->f_name) }}</p>
            <p class="text-xl text-teal-600 mt-3"><span
                    class="font-semibold text-gray-600">Last Name : </span> {{ ucwords($user->l_name) }}</p>
            <p class="text-xl text-teal-600 mt-3"><span
                    class="font-semibold text-gray-600">Reference No. : </span> {{ ucwords($user->ref_no) }}</p>
            <p class="text-xl text-teal-600 mt-3"><span
                    class="font-semibold text-gray-600">Email Address : </span> {{ $user->email }}</p>
            <p class="text-xl text-teal-600 mt-3"><span
                    class="font-semibold text-gray-600">Phone Number : </span> {{ $user->phone }}</p>
            <p class="text-xl text-teal-600 mt-3"><span
                    class="font-semibold text-gray-600">Role : </span> {{ $user->role->name }}</p>
        </div>
        @if($user->role->slug == \App\Models\Role::LECTURER)
            <div class="grid grid-cols-2 gap-4 mt-4">
                <p class="text-xl text-teal-600 mt-3"><span
                        class="font-semibold text-gray-600">Office No. : </span> {{ ucwords($user->office_no) }}</p>
                <p class="text-xl text-teal-600 mt-3"><span
                        class="font-semibold text-gray-600">Office Hours : </span> {{ $user->office_hours_from .' - '. $user->office_hours_to }}
                </p>
            </div>
            <table class="mt-16 time-table min-w-full">
                <thead>
                <tr>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach(\App\Models\TimeTable::$days as $day => $name)
                    <td>
                        @foreach($user->timeTable()->where('day', $day)->orderBy('time_start')->get() as $lesson)
                            <div class="bg-white rounded shadow p-3 mt-3">
                                <p><i class="bx bx-book align-middle mr-1"></i> {{ $lesson->course->name }}</p>
                                <p><i class="bx bxs-door-open align-middle mr-1"></i> {{ $lesson->class_no }}</p>
                                <p><i class="bx bx-time align-middle mr-1"></i> {{ $lesson->time_start }} - {{ $lesson->time_end }}</p>
                            </div>
                        @endforeach
                    </td>
                    @endforeach
                </tr>
                </tbody>
            </table>
        @endif
    </div>
</div>
