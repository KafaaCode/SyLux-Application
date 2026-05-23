<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['roles']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function($roleQuery) use ($request) {
                $roleQuery->where('name', $request->role);
            });
        }
        
        // Filter by status (active/inactive)
        if ($request->filled('status')) {
            $query->where('active', $request->status);
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSortFields = ['name', 'email', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        // Get statistics before pagination
        $allUsers = $query->get();
        $stats = [
            'total' => $allUsers->count(),
            'active' => $allUsers->where('active', 1)->count(),
            'inactive' => $allUsers->where('active', 0)->count(),
            'with_roles' => $allUsers->filter(function($user) {
                return $user->roles->count() > 0;
            })->count()
        ];
        
        // Pagination
        $perPage = $request->get('per_page', 10);
        $users = $query->paginate($perPage)->withQueryString();
        
        // Get roles for filter dropdown
        $roles = Role::pluck('name', 'name')->all();
        
        return view('admin.users.index', compact('users', 'roles', 'stats'));
    }

    public function all_users(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $users = $query->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب المستخدمين بنجاح',
            'data' => $users,
        ]);
    }


    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.users.create', compact('roles'));
    }

    public function create_user()
    {
        $allRoles = Role::pluck('name', 'name')->all();
        return view('admin.users.create', compact('allRoles'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'active' => 'nullable|boolean',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['active'] = $request->input('active', 1);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function show($id)
    {
        $user = User::with(['roles'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'active' => 'nullable|boolean',
        ]);

        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
            unset($input['password_confirmation']);
        }

        $user = User::find($id);
        $user->update($input);

        // Update roles
        if ($request->has('roles')) {
            $user->syncRoles($request->input('roles'));
        } else {
            $user->syncRoles([]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting the current user
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'لا يمكن حذف المستخدم الحالي');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}