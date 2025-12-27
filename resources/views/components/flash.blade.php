@if(session('success'))
    <div class="mb-4 p-3 border rounded bg-green-50">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-3 border rounded bg-red-50">
        {{ session('error') }}
    </div>
@endif
