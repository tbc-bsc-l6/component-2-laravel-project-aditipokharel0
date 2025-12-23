<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">My Modules</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-sm text-gray-600 mb-4">Modules assigned to you.</div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-600 border-b">
                                <th class="py-2 pr-4">Code</th>
                                <th class="py-2 pr-4">Title</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($modules as $module)
                                <tr class="border-b">
                                    <td class="py-3 pr-4">{{ $module->code }}</td>
                                    <td class="py-3 pr-4">{{ $module->title }}</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs border">
                                            {{ $module->is_active ? 'Available' : 'Archived' }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <a class="underline" href="#">View Students</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-gray-600">No modules assigned.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
