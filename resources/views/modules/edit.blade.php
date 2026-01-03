<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Module
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-4">
                    <a href="{{ route('modules.index') }}" class="text-sm text-gray-600 hover:underline">
                        ← Back to Modules
                    </a>
                </div>

                <form method="POST" action="{{ route('modules.update', $module) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Code</label>
                        <input class="border w-full rounded-md px-3 py-2 mt-1"
                               name="code"
                               value="{{ old('code', $module->code) }}" />
                        @error('code')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input class="border w-full rounded-md px-3 py-2 mt-1"
                               name="title"
                               value="{{ old('title', $module->title) }}" />
                        @error('title')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea class="border w-full rounded-md px-3 py-2 mt-1"
                                  name="description"
                                  rows="4">{{ old('description', $module->description) }}</textarea>
                        @error('description')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Teacher</label>
                        <select class="border w-full rounded-md px-3 py-2 mt-1" name="teacher_id">
                            <option value="">None</option>

                            @if(isset($teachers) && $teachers->count() === 0)
                                <option value="" disabled>No teachers found</option>
                            @endif

                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    @selected(old('teacher_id', $module->teacher_id) == $teacher->id)>
                                    {{ $teacher->name }} ({{ $teacher->email }})
                                </option>
                            @endforeach
                        </select>

                        @error('teacher_id')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-6 flex items-center gap-4">
                        <button class="underline" type="submit">
                            Update
                        </button>

                        <a class="underline" href="{{ route('modules.index') }}">
                            Back
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
