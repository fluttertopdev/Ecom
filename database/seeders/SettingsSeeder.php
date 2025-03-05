<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use anlutro\LaravelSettings\Facade as ContentSetting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tempArr = array(
            'preferred_site_language' => 'en',
            'company_name' => 'test',
            'email' => 'david@gmail.com',
            'phone' => '9131411409',
            'country' => '1', 
            'address' => 'text',
            'logo' => '50601739450151.svg',
            'favicon' => '50601739450151.svg',
            'support_email' => '',
            'enable_notifications' => '0',
            'firebase_msg_key' => '0',
            'firebase_api_key' => '0',
            'one_signal_key' => '',
            'one_signal_app_id' => '',
            'mailer' => 'smtp',
            'host' => 'smtp.googlemail.com',
            'port' => '465',
            'username' => 'socialtechnofox@gmail.com',
            'password' => 'dcnxvaeqrmrcovpl',
            'encryption' => 'ssl',
            'from_name' => 'Ecom',
            'from_email_address' => 'socialtechnofox@gmail.com',
            'enable_razorpay' => '0',
            'razorpay_key' => 'rzp_test_Oogpy8kF4jcSIr',
            'razorpay_secret' => 'dRguwbvUdoPI6WiW1Ux25Ue8',
            'enable_stripe' => '0',
            'stripe_key' => 'pk_test_51OhmuuJYPu5h8N8f1vYGxpHyxliqz77ghUX4k8umvwG4MvPMrTOH6Dt10yRQ4Ce1d32aNBl15Yrgh58SDxLFdFdz00POrhCOeT',
            'stripe_secret_key' => '',
            'enable_paypal' => '0',
            'paypal_client_id' => '',
            'paypal_secret_key' => '',
            'enable_cod' => '1',
            'is_enable_twilio' => '0',
            'twilio_account_sid' => '',
            'twilio_auth_token' => '',
            'twilio_phone_number' => '',
            'is_enable_msg91' => '0',
            'msg91_auth_key' => '',
            'msg91_sender_id' => '',
            'google_map_key' => '',
            'google_translate_api_key' => '',
            'map_api_key' => '',
            'map_api_key_server' => '',
            'enable_maintainance_mode' => '0',
            'maintainance_title' => 'Comming Soon!',
            'maintainance_short_text' => 'We are preparing something better & amazing for you.',
            'include_tax_amount' => '',
            'is_include_tax_amount_enable' => '0',
            'state' => '1',
            'city' => '1',
            'including_tax' => '0',
            'excluding_tax' => '1',
            'refundsetting' => '1',
            'helpline' => '11111111111',
            'multilanguage' => '1',
            'multicurrency' => '0',
            'headlinetext' => 'Headline test',
            'headlinelink' => 'link',
            'instagram' => '',
            'facebook' => 'en',
            'XSocialMedia' => 'en',
            'linkedin' => 'en',
            'payment_method' => 'cod',
            'description' => 'description',
            'footerimg' => '77901738417811.png',
         );
         
         foreach ($tempArr as $key => $value) {
            $check = Setting::where('key',$key)->first();
            if(!$check){
                Setting::insert([
                    'key' => $key,
                    'value' => $value,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
            }
        }
      
    }
}
