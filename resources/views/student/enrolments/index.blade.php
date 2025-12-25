<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">My Enrolments</h2>
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

                <div class="text-sm text-gray-600 mb-4">
                    These are your active modules.
                </div>

                @if($enrolments->isEmpty())
                    <div class="text-gray-600">You have no active enrolments.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-600 border-b">
                                    <th class="py-2 pr-4">Module</th>
                                    <th class="py-2 pr-4">Start Date</th>
                                    <th class="py-2 pr-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrolments as $enrolment)
                                    <tr class="border-b">
                                        <td class="py-3 pr-4">
                                            <div class="font-semibold text-gray-900">
                                                {{ $enrolment->module->code }} - {{ $enrolment->module->title }}
                                            </div>
                                            <div class="text-gray-600">
                                                {{ $enrolment->module->description }}
                                            </div>
                                        </td>
                                        <td class="py-3 pr-4">{{ $enrolment->start_date }}</td>
                                        <td class="py-3 pr-4">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs border">
                                                {{ $enrolment->status }}
                                            </span>
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
