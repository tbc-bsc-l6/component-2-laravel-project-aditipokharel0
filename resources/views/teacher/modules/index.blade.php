<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">My Modules</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

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
                    <div class="text-gray-600">No modules assigned to you yet.</div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($modules as $module)
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
                                    <a class="underline text-sm" href="{{ route('teacher.modules.students', $module) }}">View Students</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
