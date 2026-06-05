<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::withCount('categories')->latest()->paginate(20);

        return view('admin.sections.index', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image'
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('sections', 'public');
        }

        Section::create([
            'name' => $request->name,
            'image' => $image,
            'active' => true
        ]);

        return back()->with('success', 'تمت الإضافة بنجاح');
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $section->image = $request->file('image')->store('sections', 'public');
        }

        $section->name = $request->name;
        $section->save();

        return back()->with('success', 'تم التعديل بنجاح');
    }

    public function toggle(Section $section)
    {
        $section->update([
            'active' => !$section->active
        ]);

        return back()->with('success', 'تم تحديث الحالة');
    }
}