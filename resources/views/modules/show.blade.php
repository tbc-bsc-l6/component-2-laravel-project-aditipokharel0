<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Module Details</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6 border border-primary-100">
                <div class="mb-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-primary-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $module->code }}</h3>
                            <p class="text-lg text-gray-700">{{ $module->title }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($module->is_active)
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                Available
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                Archived
                            </span>
                        @endif
                    </div>
                    @if($module->description)
                        <p class="mt-4 text-gray-700">{{ $module->description }}</p>
                    @endif
                </div>

                <div class="mt-8 border-t border-gray-200 pt-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <h4 class="font-semibold text-lg text-gray-800">Active Students ({{ $enrolments->count() }})</h4>
                    </div>

                    @if($enrolments->isEmpty())
                        <div class="text-sm text-gray-600 bg-gray-50 rounded-lg p-4 border border-gray-200">No active students in this module.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left bg-primary-50 border-b-2 border-primary-200">
                                        <th class="py-3 px-4 font-semibold text-primary-900">Student</th>
                                        <th class="py-3 px-4 font-semibold text-primary-900">Email</th>
                                        <th class="py-3 px-4 font-semibold text-primary-900">Start Date</th>
                                        <th class="py-3 px-4 font-semibold text-primary-900">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrolments as $enrolment)
                                        <tr class="border-b border-gray-100 hover:bg-primary-50 transition-colors">
                                            <td class="py-3 px-4 font-medium text-gray-800">{{ $enrolment->student->name }}</td>
                                            <td class="py-3 px-4 text-gray-700">{{ $enrolment->student->email }}</td>
                                            <td class="py-3 px-4 text-gray-700">{{ \Carbon\Carbon::parse($enrolment->start_date)->format('M d, Y') }}</td>
                                            <td class="py-3 px-4">
                                                <form method="POST" action="{{ route('admin.modules.enrolments.destroy', [$module, $enrolment]) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-600 hover:text-red-800 font-medium text-sm" type="submit" onclick="return confirm('Remove this student from the module?')">
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

                <div class="mt-6 flex items-center gap-3 pt-6 border-t border-gray-200">
                    <a class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-150 shadow-md hover:shadow-lg font-medium text-sm" href="{{ route('modules.edit', $module) }}">
                        Edit Module
                    </a>
                    <a class="inline-flex items-center px-4 py-2 bg-white border border-primary-300 text-primary-700 rounded-lg hover:bg-primary-50 transition duration-150 font-medium text-sm" href="{{ route('modules.index') }}">
                        Back to Modules
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
