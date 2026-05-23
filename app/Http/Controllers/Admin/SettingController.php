<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppSetting;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = [
            'facebook_link' => AppSetting::get('social.facebook_link', ''),
            'instagram_link' => AppSetting::get('social.instagram_link', ''),
            'twitter_link' => AppSetting::get('social.twitter_link', ''),
            'linkedin_link' => AppSetting::get('social.linkedin_link', ''),
            'sender_email' => AppSetting::get('mail.sender_email', ''),
            'phone' => AppSetting::get('contact.phone', ''),
            'address' => AppSetting::get('contact.address', ''),
            'email' => AppSetting::get('contact.email', ''),
        ];
        return view('admin.settings.edit', ['settings' => (object) $settings]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'sender_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email',
        ]);

        AppSetting::set('social.facebook_link', $validated['facebook_link'] ?? null, 'string', 'social');
        AppSetting::set('social.instagram_link', $validated['instagram_link'] ?? null, 'string', 'social');
        AppSetting::set('social.twitter_link', $validated['twitter_link'] ?? null, 'string', 'social');
        AppSetting::set('social.linkedin_link', $validated['linkedin_link'] ?? null, 'string', 'social');
        AppSetting::set('mail.sender_email', $validated['sender_email'] ?? null, 'string', 'mail');
        AppSetting::set('contact.phone', $validated['phone'] ?? null, 'string', 'contact');
        AppSetting::set('contact.address', $validated['address'] ?? null, 'string', 'contact');
        AppSetting::set('contact.email', $validated['email'] ?? null, 'string', 'contact');

        return redirect()->route('admin.settings.edit')->with('success', 'تم حفظ الإعدادات بنجاح');
    }
}


