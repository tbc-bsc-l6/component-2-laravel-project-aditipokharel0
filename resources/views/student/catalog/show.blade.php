<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">{{ $module->code }} - {{ $module->title }}</h2>
            <a class="text-sm underline" href="{{ route('student.catalog.index') }}">Back to Catalog</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-700">
                    <div class="text-sm text-gray-500 mb-2">Module Description</div>
                    <div class="border rounded-md p-4">
                        {{ $module->description }}
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <form method="POST" action="{{ route('modules.enrol', $module) }}">
                        @csrf
                        <button
    type="submit"
    class="border rounded-md px-4 py-2 text-sm underline"
    onclick="return confirm('Enrol in {{ $module->code }} - {{ $module->title }}?');"
>
    Enrol
</button>

                    </form>
                </div>

                @if(session('error'))
                    <div class="mt-4 p-3 border rounded text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="mt-4 p-3 border rounded text-sm">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>




