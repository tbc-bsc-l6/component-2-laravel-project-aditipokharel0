<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Users</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="text-sm text-gray-600">Manage roles (admin / teacher / student).</div>
                    </div>
                </div>

                <div class="mb-6 border rounded p-4">
                    <div class="font-semibold mb-2">Create Teacher</div>

                    <form method="POST" action="{{ route('admin.teachers.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        @csrf

                        <input class="border rounded px-3 py-2" name="name" placeholder="Name" value="{{ old('name') }}" required>
                        <input class="border rounded px-3 py-2" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
                        <input class="border rounded px-3 py-2" name="password" type="password" placeholder="Password" required>

                        <button type="submit" class="border rounded px-3 py-2">Create</button>
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
                            <tr class="text-left text-gray-600 border-b">
                                <th class="py-2 pr-4">Name</th>
                                <th class="py-2 pr-4">Email</th>
                                <th class="py-2 pr-4">Role</th>
                                <th class="py-2 pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b">
                                    <td class="py-3 pr-4">{{ $user->name }}</td>
                                    <td class="py-3 pr-4">{{ $user->email }}</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs border">
                                            {{ $user->role ?? 'student' }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <div class="flex flex-col gap-2">
                                            <form method="POST" action="{{ route('admin.users.role', $user) }}" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')

                                                <select name="role" class="border rounded px-2 py-1 text-sm">
                                                    <option value="admin" @selected(($user->role ?? 'student') === 'admin')>admin</option>
                                                    <option value="teacher" @selected(($user->role ?? 'student') === 'teacher')>teacher</option>
                                                    <option value="student" @selected(($user->role ?? 'student') === 'student')>student</option>
                                                    <option value="old_student" @selected(($user->role ?? 'student') === 'old_student')>old_student</option>
                                                </select>

                                                <button type="submit" class="underline text-sm">Save</button>
                                            </form>

                                            @if(($user->role ?? 'student') === 'teacher')
                                                <form method="POST" action="{{ route('admin.teachers.destroy', $user) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="underline text-sm" onclick="return confirm('Remove this teacher?')">
                                                        Remove Teacher
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-gray-600">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
