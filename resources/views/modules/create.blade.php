<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Add Module</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('modules.store') }}">
                    @csrf

                    <div>
                        <label>Code</label>
                        <input class="border w-full" name="code" value="{{ old('code') }}" />
                        @error('code')<div class="text-red-600">{{ $message }}</div>@enderror
                    </div>

                    <div class="mt-4">
                        <label>Title</label>
                        <input class="border w-full" name="title" value="{{ old('title') }}" />
                        @error('title')<div class="text-red-600">{{ $message }}</div>@enderror
                    </div>

                    <div class="mt-4">
                        <label>Description</label>
                        <textarea class="border w-full" name="description">{{ old('description') }}</textarea>
                    </div>

                    <div class="mt-6">
                        <button class="underline" type="submit">Save</button>
                        <a class="underline ml-4" href="{{ route('modules.index') }}">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
