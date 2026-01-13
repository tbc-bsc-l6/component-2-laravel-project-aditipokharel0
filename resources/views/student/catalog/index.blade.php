<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Available Modules</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 border border-slate-200">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Browse Available Modules</h3>
                        <p class="text-sm text-gray-600 mt-1">Search and enrol in modules (max 4 active)</p>
                    </div>

                    <form method="GET" action="{{ route('student.catalog.index') }}" class="flex items-center gap-2 flex-wrap">
                        <input
                            name="q"
                            value="{{ $q ?? request('q') }}"
                            class="border border-slate-300 rounded-lg px-4 py-2 text-sm w-56 focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
                            placeholder="Search code, title, description"
                        />

                        <select name="teacher" class="border border-slate-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-slate-500 focus:border-slate-500">
                            <option value="">All teachers</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->id }}" @selected((string)($teacher ?? request('teacher')) === (string)$t->id)>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>

                        <button class="bg-slate-900 text-white rounded-lg px-4 py-2 text-sm hover:bg-slate-800 transition duration-150 shadow-sm hover:shadow-md font-medium" type="submit">Search</button>

                        <a class="text-sm text-slate-700 hover:text-slate-900 font-medium" href="{{ route('student.catalog.index') }}">Clear</a>
                    </form>
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

                <div class="mb-4 text-sm text-slate-600 bg-slate-50 rounded-lg px-4 py-2 border border-slate-200">
                    Showing <span class="font-semibold text-slate-900">{{ $modules->count() }}</span> of <span class="font-semibold text-slate-900">{{ $modules->total() }}</span> modules
                </div>

                @if($modules->count() === 0)
                    <div class="mt-6 p-8 bg-gray-50 rounded-xl text-center border-2 border-gray-200">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-gray-700 font-medium">No modules found</p>
                        <p class="text-sm text-gray-500 mt-2">Try different keywords or clear filters.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @foreach($modules as $module)
                            <div class="border-2 border-slate-200 rounded-lg p-6 bg-white hover:border-slate-400 hover:shadow-lg transition-all duration-200">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="font-bold text-lg text-slate-900 mb-1">
                                            {{ $module->code }}
                                        </div>
                                        <div class="font-semibold text-slate-800 mb-2">
                                            {{ $module->title }}
                                        </div>

                                        <div class="flex items-center text-xs text-slate-600 mb-2">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ optional($module->teacher)->name ?? 'Not assigned' }}
                                        </div>

                                        @if($module->description)
                                            <div class="text-sm text-slate-600 line-clamp-2">
                                                {{ $module->description }}
                                            </div>
                                        @endif
                                    </div>

                                    @if($module->is_active)
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Available
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                            Archived
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-4 pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
                                    <a href="{{ route('student.catalog.show', $module) }}" class="text-slate-700 hover:text-slate-900 font-medium text-sm">View Details</a>

                                    @if($module->is_active)
                                        <form method="POST" action="{{ route('modules.enrol', $module) }}" class="inline">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="bg-slate-900 text-white rounded-lg px-4 py-2 text-sm hover:bg-slate-800 transition duration-150 shadow-sm hover:shadow-md font-medium"
                                                onclick="return confirm('Enrol in {{ $module->code }} - {{ $module->title }}?');"
                                            >
                                                Enrol
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-sm text-slate-500 italic">Enrolment closed</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6">
                    {{ $modules->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
