<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AppSetting;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Social Media Links
        AppSetting::set('social.facebook_link', '', 'string', 'social');
        AppSetting::set('social.instagram_link', '', 'string', 'social');
        AppSetting::set('social.twitter_link', '', 'string', 'social');
        AppSetting::set('social.linkedin_link', '', 'string', 'social');
        
        // Contact Information
        AppSetting::set('contact.phone', '+963 11 1234567', 'string', 'contact');
        AppSetting::set('contact.address', '153 شارع الصناعة، المدينة الصناعية، سوريا', 'string', 'contact');
        AppSetting::set('contact.email', 'info@friptrading.com', 'string', 'contact');
        
        // Mail Settings
        AppSetting::set('mail.sender_email', 'info@friptrading.com', 'string', 'mail');
    }
}
