<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-8 border border-primary-100">
                <div class="mb-8">
                    <div class="text-gray-700 text-lg">
                        Welcome back, <span class="font-bold text-primary-700">{{ Auth::user()->name }}</span>.
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        {{ ucfirst(Auth::user()->role ?? 'student') }} Dashboard
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ url('/admin') }}" class="group block bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-white/20 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div class="font-bold text-white text-lg">Admin Dashboard</div>
                            </div>
                            <div class="text-sm text-primary-100">Manage modules, users, and roles.</div>
                        </a>

                        <a href="{{ route('modules.index') }}" class="group block bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-white/20 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div class="font-bold text-white text-lg">Modules</div>
                            </div>
                            <div class="text-sm text-primary-100">Create, edit, archive, assign teachers.</div>
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="group block bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-white/20 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div class="font-bold text-white text-lg">Users</div>
                            </div>
                            <div class="text-sm text-primary-100">Add/remove teachers, change roles.</div>
                        </a>
                    @elseif(Auth::user()->isTeacher())
                        <a href="{{ route('teacher.modules.index') }}" class="group block bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-white/20 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div class="font-bold text-white text-lg">My Modules</div>
                            </div>
                            <div class="text-sm text-primary-100">View assigned modules and students.</div>
                        </a>

                        <a href="{{ route('teacher.modules.index') }}" class="group block bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-white/20 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="font-bold text-white text-lg">Mark Results</div>
                            </div>
                            <div class="text-sm text-primary-100">Open a module and mark PASS/FAIL for students.</div>
                        </a>

                        <a href="{{ route('teacher.modules.index') }}" class="group block bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl p-6 hover:from-blue-500 hover:to-blue-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-white/20 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="font-bold text-white text-lg">Quick Tip</div>
                            </div>
                            <div class="text-sm text-blue-100">Only modules assigned to you will appear in My Modules.</div>
                        </a>
                    @elseif(Auth::user()->isStudent())
                        <a href="{{ route('student.catalog.index') }}" class="group block bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-white/20 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <div class="font-bold text-white text-lg">Available Modules</div>
                            </div>
                            <div class="text-sm text-primary-100">Browse and enrol (max 4 active).</div>
                        </a>

                        <a href="{{ route('student.enrolments.index') }}" class="group block bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-white/20 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div class="font-bold text-white text-lg">My Enrolments</div>
                            </div>
                            <div class="text-sm text-primary-100">View active enrolled modules.</div>
                        </a>

                        <a href="{{ route('student.history.index') }}" class="group block bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-white/20 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="font-bold text-white text-lg">History</div>
                            </div>
                            <div class="text-sm text-primary-100">Completed modules with PASS/FAIL.</div>
                        </a>
                    @elseif(Auth::user()->isOldStudent())
                        <a href="{{ route('student.history.index') }}" class="group block bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-white/20 rounded-lg p-2 mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="font-bold text-white text-lg">History</div>
                            </div>
                            <div class="text-sm text-primary-100">Completed modules with PASS/FAIL.</div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
