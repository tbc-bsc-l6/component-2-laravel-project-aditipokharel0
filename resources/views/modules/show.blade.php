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

                <div class="mt-8">
                    <div class="font-semibold mb-2">Active Students</div>

                    @if($enrolments->isEmpty())
                        <div class="text-sm text-gray-600">No active students in this module.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-600 border-b">
                                        <th class="py-2 pr-4">Student</th>
                                        <th class="py-2 pr-4">Email</th>
                                        <th class="py-2 pr-4">Start Date</th>
                                        <th class="py-2 pr-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrolments as $enrolment)
                                        <tr class="border-b">
                                            <td class="py-3 pr-4">{{ $enrolment->student->name }}</td>
                                            <td class="py-3 pr-4">{{ $enrolment->student->email }}</td>
                                            <td class="py-3 pr-4">{{ $enrolment->start_date }}</td>
                                            <td class="py-3 pr-4">
                                                <form method="POST" action="{{ route('admin.modules.enrolments.destroy', [$module, $enrolment]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="underline" type="submit" onclick="return confirm('Remove this student from the module?')">
                                                        Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <div class="mt-6">
                    <a class="underline" href="{{ route('modules.edit', $module) }}">Edit</a>
                    <a class="underline ml-4" href="{{ route('modules.index') }}">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
