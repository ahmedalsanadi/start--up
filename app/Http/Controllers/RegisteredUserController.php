<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\ImageFile;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view("auth.register");
    }

    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            "name" => ["required", "string"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "confirmed", Password::min(6)],
            "phone_number" => ["required", "string"],
            "city" => ["required", "string"],
            "address" => ["required", "string"],
            "user_type" => ["required", "integer"],
            'profile_image' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'privacy_policy' => ['required', 'accepted'],
        ], [
            "name.required" => "الاسم مطلوب.",
            "name.string" => "يجب أن يكون الاسم نصًا.",
            "email.required" => "البريد الإلكتروني مطلوب.",
            "email.email" => "يرجى إدخال بريد إلكتروني صالح.",
            "email.unique" => "البريد الإلكتروني مستخدم بالفعل.",
            "password.required" => "كلمة المرور مطلوبة.",
            "password.confirmed" => "تأكيد كلمة المرور غير متطابق.",
            "password.min" => "يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل.",
            "phone_number.required" => "رقم الهاتف مطلوب.",
            "phone_number.string" => "يجب أن يكون رقم الهاتف نصًا.",
            "city.required" => "المدينة مطلوبة.",
            "city.string" => "يجب أن تكون المدينة نصًا.",
            "address.required" => "العنوان مطلوب.",
            "address.string" => "يجب أن يكون العنوان نصًا.",
            "user_type.required" => "نوع المستخدم مطلوب.",
            "user_type.integer" => "يجب أن يكون نوع المستخدم رقمًا صحيحًا.",
            "profile_image.image" => "يجب أن يكون الملف صورة.",
            "profile_image.mimes" => "يجب أن تكون الصورة بصيغة png أو jpg أو jpeg أو webp أو svg.",
            "profile_image.max" => "يجب ألا يتجاوز حجم الصورة 2 ميغابايت.",
            "privacy_policy.required" => "يجب الموافقة على سياسة الخصوصية.",
            "privacy_policy.accepted" => "يجب الموافقة على سياسة الخصوصية للمتابعة.",
        ]);

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profiles', 'public');
            $userAttributes['profile_image'] = $imagePath;
        }

        $user = User::create(array_merge($userAttributes, [
            'is_active' => true,
            'privacy_policy' => true,
        ]));

        if ($user) {
            Auth::login($user);
            Session::flash('success', 'تم التسجيل بنجاح.');
            return redirect()->route('dashboard');
        }

        Session::flash('error', 'عذرًا! فشل التسجيل.');
        return back()->withInput();
    }

}
