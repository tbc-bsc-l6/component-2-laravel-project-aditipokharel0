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
