<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-2.5 bg-slate-900 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:bg-slate-800 focus:bg-slate-800 active:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
