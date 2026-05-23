<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\CountryTranslation;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $query = Country::with('translations');
        
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
        $allCountries = $query->get();
        $stats = [
            'total' => $allCountries->count(),
        ];
        
        // Pagination
        $perPage = $request->get('per_page', 10);
        $countries = $query->paginate($perPage)->withQueryString();
        
        return view('admin.countries.index', compact('countries', 'stats'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:countries,name',
        ]);

        $country = Country::create([
            'name' => $request->input('name'),
        ]);

        // Save translations
        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $translationData) {
                if (!empty($translationData['name_translated'])) {
                    CountryTranslation::create([
                        'country_id' => $country->id,
                        'locale' => $locale,
                        'name_translated' => $translationData['name_translated']
                    ]);
                }
            }
        }

        return redirect()->route('admin.countries.index')
            ->with('success', 'تم إنشاء الدولة بنجاح');
    }

    public function edit($id)
    {
        $country = Country::with('translations')->findOrFail($id);
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:countries,name,' . $id,
        ]);

        $country = Country::findOrFail($id);
        $country->name = $request->input('name');
        $country->save();

        // Save translations
        if ($request->has('translations')) {
            foreach ($request->input('translations') as $locale => $translationData) {
                if (!empty($translationData['name_translated'])) {
                    CountryTranslation::updateOrCreate(
                        [
                            'country_id' => $country->id,
                            'locale' => $locale
                        ],
                        [
                            'name_translated' => $translationData['name_translated']
                        ]
                    );
                }
            }
        }

        return redirect()->route('admin.countries.index')
            ->with('success', 'تم تحديث الدولة بنجاح');
    }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        
        // Check if country has categories
        if ($country->categories->count() > 0) {
            return redirect()->route('admin.countries.index')
                ->with('error', 'لا يمكن حذف هذه الدولة لأنها مرتبطة بفئات. يرجى نقل الفئات إلى دولة أخرى أولاً.');
        }
        
        $country->delete();

        return redirect()->route('admin.countries.index')
            ->with('success', 'تم حذف الدولة بنجاح');
    }
}
