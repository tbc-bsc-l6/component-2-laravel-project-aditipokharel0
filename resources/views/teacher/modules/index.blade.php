<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">My Modules</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6 border border-primary-100">

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

                @if($modules->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <p class="text-gray-600 text-lg">No modules assigned to you yet.</p>
                        <p class="text-gray-500 text-sm mt-2">Contact an administrator to get assigned to modules.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($modules as $module)
                            <div class="border-2 border-primary-200 rounded-xl p-6 bg-gradient-to-br from-white to-primary-50 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="font-bold text-lg text-gray-900 mb-1">{{ $module->code }}</div>
                                        <div class="font-semibold text-gray-800 mb-2">{{ $module->title }}</div>
                                        @if($module->description)
                                            <div class="text-sm text-gray-600 line-clamp-2">{{ $module->description }}</div>
                                        @endif
                                    </div>
                                    @if($module->is_active)
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                            Archived
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-4 pt-4 border-t border-primary-200">
                                    <a class="inline-flex items-center justify-center w-full px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-150 shadow-md hover:shadow-lg font-medium text-sm" href="{{ route('teacher.modules.students', $module) }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        View Students
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
