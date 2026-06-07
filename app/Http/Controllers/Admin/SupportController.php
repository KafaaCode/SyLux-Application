<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $query = Support::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('sender_name', 'like', "%{$search}%")
                  ->orWhere('sender_email', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 10);
        $supports = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.supports.index', compact('supports'));
    }

    public function show($id)
    {
        $support = Support::findOrFail($id);
        return view('admin.supports.show', compact('support'));
    }

    public function destroy($id)
    {
        $support = Support::findOrFail($id);
        $support->delete();

        return redirect()->route('admin.supports.index')
            ->with('success', 'تم حذف رسالة الدعم بنجاح');
    }
}
