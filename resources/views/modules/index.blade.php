<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            Modules
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('modules.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-150 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Module
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6 border border-primary-100">
                <table class="w-full">
                    <thead>
                        <tr class="bg-primary-50 border-b-2 border-primary-200">
                            <th class="text-left py-3 px-4 font-semibold text-primary-900">Code</th>
                            <th class="text-left py-3 px-4 font-semibold text-primary-900">Title</th>
                            <th class="text-left py-3 px-4 font-semibold text-primary-900">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-primary-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modules as $module)
                            <tr class="border-b border-gray-100 hover:bg-primary-50 transition-colors">
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $module->code }}</td>
                                <td class="py-3 px-4 text-gray-700">{{ $module->title }}</td>
                                <td class="py-3 px-4">
                                    @if($module->is_active)
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Available
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                            Archived
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <a class="text-primary-600 hover:text-primary-800 font-medium text-sm" href="{{ route('modules.show', $module) }}">
                                            View
                                        </a>
                                        <span class="text-gray-300">|</span>
                                        <a class="text-primary-600 hover:text-primary-800 font-medium text-sm" href="{{ route('modules.edit', $module) }}">
                                            Edit
                                        </a>
                                        <span class="text-gray-300">|</span>
                                        @if($module->is_active)
                                            <form class="inline" method="POST" action="{{ route('modules.archive', $module) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="text-orange-600 hover:text-orange-800 font-medium text-sm" type="submit">
                                                    Archive
                                                </button>
                                            </form>
                                        @else
                                            <form class="inline" method="POST" action="{{ route('modules.unarchive', $module) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="text-primary-600 hover:text-primary-800 font-medium text-sm" type="submit">
                                                    Unarchive
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-8 text-center text-gray-500" colspan="4">
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
