<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Module Details</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p><strong>Code:</strong> {{ $module->code }}</p>
                <p class="mt-2"><strong>Title:</strong> {{ $module->title }}</p>
                <p class="mt-2"><strong>Status:</strong> {{ $module->is_active ? 'Available' : 'Archived' }}</p>
                <p class="mt-4">{{ $module->description }}</p>

                <div class="mt-6">
                    <a class="underline" href="{{ route('modules.edit', $module) }}">Edit</a>
                    <a class="underline ml-4" href="{{ route('modules.index') }}">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
