<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="text-gray-700">
                    Welcome, <span class="font-semibold">{{ Auth::user()->name }}</span>.
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">

                    @if(Auth::user()->isAdmin())
                        <a href="{{ url('/admin') }}" class="block border rounded-lg p-4 hover:bg-gray-50">
                            <div class="font-semibold">Admin Dashboard</div>
                            <div class="text-sm text-gray-600 mt-1">Manage modules, users, and roles.</div>
                        </a>

                        <a href="{{ route('modules.index') }}" class="block border rounded-lg p-4 hover:bg-gray-50">
                            <div class="font-semibold">Modules</div>
                            <div class="text-sm text-gray-600 mt-1">Create, edit, archive, assign teachers.</div>
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="block border rounded-lg p-4 hover:bg-gray-50">
                            <div class="font-semibold">Users</div>
                            <div class="text-sm text-gray-600 mt-1">Add/remove teachers, change roles.</div>
                        </a>
                    @endif

                    @if(Auth::user()->isTeacher())
                        <a href="{{ route('teacher.modules.index') }}" class="block border rounded-lg p-4 hover:bg-gray-50">
                            <div class="font-semibold">My Modules</div>
                            <div class="text-sm text-gray-600 mt-1">View assigned modules and students.</div>
                        </a>

                        <div class="border rounded-lg p-4">
                            <div class="font-semibold">Mark Results</div>
                            <div class="text-sm text-gray-600 mt-1">Set PASS/FAIL with timestamp (backend next).</div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <div class="font-semibold">Quick Tip</div>
                            <div class="text-sm text-gray-600 mt-1">Only modules assigned to you should show here.</div>
                        </div>
                    @endif

                    @if(!Auth::user()->isAdmin() && !Auth::user()->isTeacher())
                        <a href="{{ route('student.catalog.index') }}" class="block border rounded-lg p-4 hover:bg-gray-50">
                            <div class="font-semibold">Available Modules</div>
                            <div class="text-sm text-gray-600 mt-1">Browse and enrol (max 4 later).</div>
                        </a>

                        <a href="{{ route('student.enrolments.index') }}" class="block border rounded-lg p-4 hover:bg-gray-50">
                            <div class="font-semibold">My Enrolments</div>
                            <div class="text-sm text-gray-600 mt-1">View active enrolled modules.</div>
                        </a>

                        <a href="{{ route('student.history.index') }}" class="block border rounded-lg p-4 hover:bg-gray-50">
                            <div class="font-semibold">History</div>
                            <div class="text-sm text-gray-600 mt-1">Completed modules with PASS/FAIL.</div>
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
