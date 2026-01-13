<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white">Users</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 border border-slate-200">

                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="text-sm text-gray-600">Manage roles (admin / teacher / student).</div>
                    </div>
                </div>

                <div class="mb-6 border-2 border-slate-200 rounded-lg p-6 bg-slate-50">
                    <div class="font-semibold text-lg text-slate-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Create Teacher
                    </div>

                    <form method="POST" action="{{ route('admin.teachers.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        @csrf

                        <input class="border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-slate-500 focus:border-slate-500" name="name" placeholder="Name" value="{{ old('name') }}" required>
                        <input class="border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-slate-500 focus:border-slate-500" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
                        <input class="border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-slate-500 focus:border-slate-500" name="password" type="password" placeholder="Password" required>

                        <button type="submit" class="bg-slate-900 text-white rounded-lg px-4 py-2 hover:bg-slate-800 transition duration-150 shadow-sm hover:shadow-md font-medium">Create</button>
                    </form>

                    @if($errors->any())
                        <div class="mt-3 text-sm text-red-600">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if(session('success'))
                    <div class="mb-4 p-3 border rounded text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-3 border rounded text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left bg-slate-50 border-b-2 border-slate-200">
                                <th class="py-3 px-4 font-semibold text-slate-900">Name</th>
                                <th class="py-3 px-4 font-semibold text-slate-900">Email</th>
                                <th class="py-3 px-4 font-semibold text-slate-900">Role</th>
                                <th class="py-3 px-4 font-semibold text-slate-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 font-medium text-gray-800">{{ $user->name }}</td>
                                    <td class="py-3 px-4 text-gray-700">{{ $user->email }}</td>
                                    <td class="py-3 px-4">
                                        @php
                                            $role = $user->role ?? 'student';
                                            $roleColors = [
                                                'admin' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                'teacher' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'student' => 'bg-green-100 text-green-800 border-green-200',
                                                'old_student' => 'bg-gray-100 text-gray-800 border-gray-200',
                                            ];
                                            $colorClass = $roleColors[$role] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium border {{ $colorClass }}">
                                            {{ $role }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-2">
                                            <form method="POST" action="{{ route('admin.users.role', $user) }}" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')

                                                <select name="role" class="border border-slate-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-slate-500 focus:border-slate-500">
                                                    <option value="admin" @selected(($user->role ?? 'student') === 'admin')>admin</option>
                                                    <option value="teacher" @selected(($user->role ?? 'student') === 'teacher')>teacher</option>
                                                    <option value="student" @selected(($user->role ?? 'student') === 'student')>student</option>
                                                    <option value="old_student" @selected(($user->role ?? 'student') === 'old_student')>old_student</option>
                                                </select>

                                                <button type="submit" class="text-slate-700 hover:text-slate-900 font-medium text-sm">Save</button>
                                            </form>

                                            @if(($user->role ?? 'student') === 'teacher')
                                                <form method="POST" action="{{ route('admin.teachers.destroy', $user) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm" onclick="return confirm('Remove this teacher?')">
                                                        Remove Teacher
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
