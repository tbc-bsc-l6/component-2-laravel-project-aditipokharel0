<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::orderBy('title')->get();
        return view('modules.index', compact('modules'));
    }

    public function create()
    {
        return view('modules.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:modules,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Module::create($data);

        return redirect()->route('modules.index');
    }

    public function show(Module $module)
    {
        return view('modules.show', compact('module'));
    }

    public function edit(Module $module)
    {
        return view('modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:modules,code,' . $module->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $module->update($data);

        return redirect()->route('modules.index');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('modules.index');
    }
    public function archive(Module $module)
{
    $module->update(['is_active' => false]);
    return redirect()->route('modules.index');
}

public function unarchive(Module $module)
{
    $module->update(['is_active' => true]);
    return redirect()->route('modules.index');
}

    
}
