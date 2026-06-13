<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::orderBy('value')->paginate(10);
        return view('admin.levels.index', compact('levels'));
    }

    public function create()
    {
        return view('admin.levels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:50',
            'value' => 'required|integer|unique:levels,value',
        ]);

        Level::create($validated);

        return redirect()->route('admin.levels.index')
                         ->with('success', 'Level created successfully.');
    }

    public function edit(Level $level)
    {
        return view('admin.levels.edit', compact('level'));
    }

    public function update(Request $request, Level $level)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:50',
            'value' => 'required|integer|unique:levels,value,' . $level->id,
        ]);

        $level->update($validated);

        return redirect()->route('admin.levels.index')
                         ->with('success', 'Level updated.');
    }

    public function destroy(Level $level)
    {
        $level->delete();
        return redirect()->route('admin.levels.index')
                         ->with('success', 'Level deleted.');
    }
}