<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\SpecializationTranslation;

class SpecializationController extends Controller
{
    public function index(Request $request)
    {
        $query = Specialization::with('translations');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSortFields = ['name', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        // Get statistics
        $allSpecializations = $query->get();
        $stats = [
            'total' => $allSpecializations->count(),
        ];
        
        // Pagination
        $perPage = $request->get('per_page', 10);
        $specializations = $query->paginate($perPage)->withQueryString();
        
        return view('admin.specializations.index', compact('specializations', 'stats'));
    }

    public function create()
    {
        return view('admin.specializations.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:specializations,name',
        ]);

        $specialization = Specialization::create([
            'name' => $request->input('name'),
        ]);

        // Save translations
        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $translationData) {
                if (!empty($translationData['name_translated'])) {
                    SpecializationTranslation::create([
                        'specialization_id' => $specialization->id,
                        'locale' => $locale,
                        'name_translated' => $translationData['name_translated']
                    ]);
                }
            }
        }

        return redirect()->route('admin.specializations.index')
            ->with('success', 'تم إنشاء التخصص بنجاح');
    }

    public function edit($id)
    {
        $specialization = Specialization::with('translations')->findOrFail($id);
        return view('admin.specializations.edit', compact('specialization'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:specializations,name,' . $id,
        ]);

        $specialization = Specialization::findOrFail($id);
        $specialization->name = $request->input('name');
        $specialization->save();

        // Save translations
        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $translationData) {
                if (!empty($translationData['name_translated'])) {
                    SpecializationTranslation::updateOrCreate(
                        [
                            'specialization_id' => $specialization->id,
                            'locale' => $locale
                        ],
                        [
                            'name_translated' => $translationData['name_translated']
                        ]
                    );
                }
            }
        }

        return redirect()->route('admin.specializations.index')
            ->with('success', 'تم تحديث التخصص بنجاح');
    }

    public function destroy($id)
    {
        $specialization = Specialization::findOrFail($id);
        
        // Check if specialization has categories
        if ($specialization->categories->count() > 0) {
            return redirect()->route('admin.specializations.index')
                ->with('error', 'لا يمكن حذف هذا التخصص لأنه مرتبط بفئات. يرجى نقل الفئات إلى تخصص آخر أولاً.');
        }
        
        $specialization->delete();

        return redirect()->route('admin.specializations.index')
            ->with('success', 'تم حذف التخصص بنجاح');
    }
}
