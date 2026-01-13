<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Students - {{ $module->code }} {{ $module->title }}
            </h2>
            <a href="{{ route('teacher.modules.index') }}" class="underline text-sm">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 p-3 border rounded text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($enrolments->isEmpty())
                    <div class="text-gray-600">No active students in this module.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-600 border-b">
                                    <th class="py-2 pr-4">Student</th>
                                    <th class="py-2 pr-4">Email</th>
                                    <th class="py-2 pr-4">Start Date</th>
                                    <th class="py-2 pr-4">Mark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrolments as $enrolment)
                                    <tr class="border-b">
                                        <td class="py-3 pr-4">{{ $enrolment->student->name ?? 'Student' }}</td>
                                        <td class="py-3 pr-4">{{ $enrolment->student->email ?? '-' }}</td>
                                        <td class="py-3 pr-4">{{ $enrolment->start_date }}</td>
                                        <td class="py-3 pr-4">
                                            <div class="flex items-center gap-2">
                                                <form method="POST" action="{{ route('teacher.enrolments.mark', $enrolment) }}">
                                                    @csrf
                                                    <input type="hidden" name="result" value="PASS">
                                                    <button type="submit" class="underline text-sm">PASS</button>
                                                </form>

                                                <form method="POST" action="{{ route('teacher.enrolments.mark', $enrolment) }}">
                                                    @csrf
                                                    <input type="hidden" name="result" value="FAIL">
                                                    <button type="submit" class="underline text-sm">FAIL</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
