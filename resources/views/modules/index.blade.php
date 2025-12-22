<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Modules
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('modules.create') }}" class="underline">
                    Add Module
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="text-left">Code</th>
                            <th class="text-left">Title</th>
                            <th class="text-left">Status</th>
                            <th class="text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modules as $module)
                            <tr class="border-t">
                                <td class="py-2">{{ $module->code }}</td>
                                <td class="py-2">{{ $module->title }}</td>
                                <td class="py-2">
                                    {{ $module->is_active ? 'Available' : 'Archived' }}
                                </td>
                                <td class="py-2">

                                    <a class="underline" href="{{ route('modules.show', $module) }}">
                                        View
                                    </a>
                                    <span class="mx-2">|</span>

                                    <a class="underline" href="{{ route('modules.edit', $module) }}">
                                        Edit
                                    </a>
                                    <span class="mx-2">|</span>

                                    @if($module->is_active)
                                        <form class="inline" method="POST" action="{{ route('modules.archive', $module) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="underline" type="submit">
                                                Archive
                                            </button>
                                        </form>
                                    @else
                                        <form class="inline" method="POST" action="{{ route('modules.unarchive', $module) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="underline" type="submit">
                                                Unarchive
                                            </button>
                                        </form>
                                    @endif

                                    <span class="mx-2">|</span>

                                    <form class="inline" method="POST" action="{{ route('modules.destroy', $module) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="underline" type="submit"
                                            onclick="return confirm('Are you sure you want to delete this module?')">
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-4" colspan="4">
                                    No modules yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
