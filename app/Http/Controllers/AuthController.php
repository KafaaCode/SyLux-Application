<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function specializationAndcountry()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'تم استرجاع التخصصات والدول بنجاح',
            'data' => [
                'specializations' => \App\Models\Specialization::select('name', 'id')->get(),
                'countries' => \App\Models\Country::select('name', 'id')->get(),
            ]
        ], 200);
    }

    // تسجيل حساب جديد
    public function register(Request $request)
    {
        $validated = $request->validate([
            'companyName' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed', // يجب إرسال حقل password_confirmation أيضًا
            'specialization_id' => 'required|exists:specializations,id',
            'country_id' => 'required|exists:countries,id',
        ]);

        $user = User::create([
            'companyName' => $validated['companyName'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'specialization_id' => $validated['specialization_id'],
            'country_id' => $validated['country_id'],
            'status' => 0, // الحالة افتراضيًا مفعل
        ]);

        $user->assignRole('User');

        // إنشاء توكن باستخدام Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        $user['role'] = $user->getRoleNames()->first();

        return response()->json([
            'status' => 'success',
            'message' => 'تم إنشاء الحساب بنجاح',
            'data' => [
                'user' => $user,
                'role' => $user->getRoleNames()->first(),
                'access_token' => $token,
            ]
        ], 201);
    }

    // تسجيل الدخول
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات الاعتماد غير صحيحة',
            ], 401);
        }
        $user['role'] = $user->getRoleNames()->first();
        // إنشاء توكن جديد
        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الدخول بنجاح',
            'data' => [
                'user' => $user,
                // 'role' => $user->getRoleNames()->first(),
                'access_token' => $token,
            ]
        ], 200);
    }

    // عرض البروفايل الخاص بالمستخدم
    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'تم استرجاع البروفايل بنجاح',
            'data' => $request->user()
        ], 200);
    }

    // تحديث البروفايل
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'companyName' => 'sometimes|required|string|max:255',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'specialization_id' => 'sometimes|required|exists:specializations,id',
            'country_id' => 'sometimes|required|exists:countries,id',
        ]);

        $user->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث البروفايل بنجاح',
            'data' => $user,
        ], 200);
    }

    // تغيير كلمة المرور بعد التحقق من كلمة المرور الحالية
    public function changePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed', // يجب إرسال new_password_confirmation أيضًا
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'كلمة المرور الحالية غير صحيحة',
            ], 400);
        }

        $user->update([
            'password' => bcrypt($validated['new_password']),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم تغيير كلمة المرور بنجاح',
        ], 200);
    }

    // تسجيل الخروج: إلغاء التوكن الحالي
    public function logout(Request $request)
    {
        // تحقق إذا كان المستخدم يحتوي على توكن حالي
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الخروج بنجاح'
        ], 200);
    }

    // حذف حساب المستخدم
    public function deleteAccount(Request $request)
    {
        $user = $request->user();
        
        // حذف جميع التوكنات الخاصة بالمستخدم
        $user->tokens()->delete();
        
        // حذف المستخدم من قاعدة البيانات
        $user->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'تم حذف الحساب بنجاح'
        ], 200);
    }

}
