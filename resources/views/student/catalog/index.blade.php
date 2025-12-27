<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Available Modules</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-sm text-gray-600">Browse modules you can enrol into.</div>

                    <form method="GET" action="{{ route('student.catalog.index') }}" class="flex items-center gap-2">
                        <input
                            name="q"
                            value="{{ $q ?? request('q') }}"
                            class="border rounded-md px-3 py-2 text-sm w-56"
                            placeholder="Search code, title, description"
                        />

                        <select name="teacher" class="border rounded-md px-3 py-2 text-sm">
                            <option value="">All teachers</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->id }}" @selected((string)($teacher ?? request('teacher')) === (string)$t->id)>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>

                        <button class="border rounded-md px-3 py-2 text-sm" type="submit">Search</button>

                        <a class="text-sm underline" href="{{ route('student.catalog.index') }}">Clear</a>
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($modules as $module)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $module->code }} - {{ $module->title }}</div>
                                    <div class="text-sm text-gray-600 mt-1">{{ $module->description }}</div>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs border">
                                    {{ $module->is_active ? 'Available' : 'Archived' }}
                                </span>
                            </div>

                            <div class="mt-4 flex items-center justify-end gap-3">
                                <a href="{{ route('student.catalog.show', $module) }}" class="underline text-sm">View</a>

                                @if($module->is_active)
                                    <form method="POST" action="{{ route('modules.enrol', $module) }}">
                                        @csrf
                                        <button type="submit" class="text-sm underline">Enrol</button>
                                    </form>
                                @else
                                    <span class="text-sm text-gray-500">Enrol closed</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-600">No available modules.</div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $modules->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
