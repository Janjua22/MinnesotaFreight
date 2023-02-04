<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SiteSetting::truncate();
        $data = [
            ['key' => 'logo','value' => NULL,'type' => '2','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'donate','value' => NULL,'type' => '2','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'title','value' => 'United Freight','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'about','value' => 'About will be here','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'contact','value' => '+1 234 567 8901','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'email','value' => 'info@united-freight.com','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'address','value' => 'Complete address will be here','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'facebook','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'instagram','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'twitter','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'google','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'linkedin','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'map_key','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'youtube','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'logo_white','value' => NULL,'type' => '2','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'contact_form_email','value' => '0','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'PUSHER_APP_ID','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'PUSHER_APP_KEY','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'PUSHER_APP_SECRET','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'PUSHER_APP_CLUSTER','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'PAYPAL_CLIENT_ID','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'PAYPAL_SECRET','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'PAYPAL_MODE','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'VOYANAGE_APP_KEY','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'VOYANAGE_API_KEY','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'custom_header','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'custom_footer','value' => NULL,'type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'primary','value' => '#009ef7','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'secondary','value' => '#e4e6ef','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'success','value' => '#50cd89','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'info','value' => '#7239ea','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'warning','value' => '#ffc700','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'danger','value' => '#f1416c','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'light','value' => '#f5f8fa','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'dark','value' => '#181c32','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'primary_active','value' => '#0095e8','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'secondary_active','value' => '#b5b5c3','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'success_active','value' => '#47be7d','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'info_active','value' => '#7239ea','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'warning_active','value' => '#f1bc00','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'danger_active','value' => '#d9214e','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'light_active','value' => '#e4e6ef','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'dark_active','value' => '#131628','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'primary_light','value' => '#ecf8ff','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'secondary_light','value' => '#ECF8FF','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'success_light','value' => '#e8fff3','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'info_light','value' => '#f8f5ff','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'warning_light','value' => '#fff8dd','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'danger_light','value' => '#fff5f8','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'light_light','value' => '#E4E6EF','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'dark_light','value' => '#eff2f5','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'logo_background','value' => '#1a1a27','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'header_background','value' => '#1e1e2d','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'sidebar_background','value' => '#1e1e2d','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'sidebar_active','value' => '#db1430','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'login','value' => '1','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'register','value' => '1','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'reset','value' => '1','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'verify','value' => '1','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'title_401','value' => 'Unauthorized','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'message_401','value' => 'You don\'t have a valid authorization to access this.','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'title_403','value' => 'Forbidden','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'message_403','value' => 'You are trying to access a forbidden area.','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'title_404','value' => 'Page not found','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'message_404','value' => 'The page you are looking might have been removed had its name changed or is temporarily unavailable.','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'title_419','value' => 'Page Expired','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'message_419','value' => 'We are sorry the page you are accessing is expired.','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'title_429','value' => 'Too Many Requests','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'message_429','value' => 'Too Many Requests. What are you doing sir ?','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'title_500','value' => 'Server Error','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'message_500','value' => 'Oops. Server has faced some issue !','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'title_503','value' => 'Service Unavailable','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'message_503','value' => 'Oops. Service is not available right now !','type' => '1','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'auth_bg','value' => 'img/logo/w5FZAeOiIqPZkZ1KetPM3roVMGI38s1pT0GJT6QB.jpg','type' => '2','status' => '1','created_at' => now(),'updated_at' => now()],
            ['key' => 'auth_text_bg','value' => 'img/logo/fsVslpXEK466ub8dBPYriw8rTLn98Wj5O0gdEQyB.jpg','type' => '2','status' => '1','created_at' => now(),'updated_at' => now()]
            ];

        Role::insert($SiteSetting);
    }
}
