<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use anlutro\LaravelSettings\Facade as ContentSetting;
use Illuminate\Support\Facades\Session;

class Setting extends Model
{
   protected $fillable = [
        'key',
        'value',
    ];







  public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

   public static function updateContent($data)
   {


      try{

        $obj = new self;
        unset($data['_token']);
        $page_name = (isset($data['page_name'])) ? $data['page_name'] : '';
        unset($data['page_name']);

         
        if ($page_name != '') {

            if ($page_name == 'payment_methods') {
                $payment_method = (isset($data['payment_method'])) ? $data['payment_method'] : '';

                if ($payment_method == 'razorpay') {
                    $razorpay_key = (isset($data['razorpay_key'])) ? $data['razorpay_key'] : '';
                    $razorpay_secret = (isset($data['razorpay_secret'])) ? $data['razorpay_secret'] : '';
                    $enable_razorpay = (isset($data['enable_razorpay'])) ? 1 : 0;

                    // Update Razorpay settings in Setting
                    Setting::updateOrCreate(['key' => 'razorpay_key'], ['value' => $razorpay_key]);
                    Setting::updateOrCreate(['key' => 'razorpay_secret'], ['value' => $razorpay_secret]);
                    Setting::updateOrCreate(['key' => 'enable_razorpay'], ['value' => $enable_razorpay]);
                } elseif ($payment_method == 'stripe') {
                    $stripe_key = (isset($data['stripe_key'])) ? $data['stripe_key'] : '';
                    $stripe_secret_key = (isset($data['stripe_secret_key'])) ? $data['stripe_secret_key'] : '';
                    $enable_stripe = (isset($data['enable_stripe'])) ? 1 : 0;

                    // Update Stripe settings in Setting
                    Setting::updateOrCreate(['key' => 'stripe_key'], ['value' => $stripe_key]);
                    Setting::updateOrCreate(['key' => 'stripe_secret_key'], ['value' => $stripe_secret_key]);
                    Setting::updateOrCreate(['key' => 'enable_stripe'], ['value' => $enable_stripe]);
                } elseif ($payment_method == 'paypal') {
                    $paypal_client_id = (isset($data['paypal_client_id'])) ? $data['paypal_client_id'] : '';
                    $paypal_secret_key = (isset($data['paypal_secret_key'])) ? $data['paypal_secret_key'] : '';
                    $enable_paypal = (isset($data['enable_paypal'])) ? 1 : 0;

                    // Update Paypal settings in Setting
                    Setting::updateOrCreate(['key' => 'paypal_client_id'], ['value' => $paypal_client_id]);
                    Setting::updateOrCreate(['key' => 'paypal_secret_key'], ['value' => $paypal_secret_key]);
                    Setting::updateOrCreate(['key' => 'enable_paypal'], ['value' => $enable_paypal]);
                } elseif ($payment_method == 'cod') {
                    $enable_cod = (isset($data['enable_cod'])) ? 1 : 0;

                    // Update COD settings in Setting
                    Setting::updateOrCreate(['key' => 'enable_cod'], ['value' => $enable_cod]);
                }
            }


            if ($page_name == 'company-setting') {
               


                if(isset($data['logo']) && $data['logo']!=''){
                    $uploadImage = \Helpers::uploadFiles($data['logo'],'setting/');
                    if($uploadImage['status']==true){
                        $data['logo'] = $uploadImage['file_name'];
                    }
                }
                
                
                if(isset($data['footerimg']) && $data['footerimg']!=''){
                    $uploadImage = \Helpers::uploadFiles($data['footerimg'],'setting/');
                    if($uploadImage['status']==true){
                        $data['footerimg'] = $uploadImage['file_name'];
                    }
                }
                if(isset($data['website_admin_logo']) && $data['website_admin_logo']!=''){
                    $uploadImage = \Helpers::uploadFiles($data['website_admin_logo'],'setting/');
                    if($uploadImage['status']==true){
                        $data['website_admin_logo'] = $uploadImage['file_name'];
                    }
                }
                if(isset($data['site_favicon']) && $data['site_favicon']!=''){
                    $uploadImage = \Helpers::uploadFiles($data['site_favicon'],'setting/');
                    if($uploadImage['status']==true){
                        $data['site_favicon'] = $uploadImage['file_name'];
                    }
                }
                
                 if(isset($data['favicon']) && $data['favicon']!=''){
                    $uploadImage = \Helpers::uploadFiles($data['favicon'],'setting/');
                    if($uploadImage['status']==true){
                        $data['favicon'] = $uploadImage['file_name'];
                    }
                }
                  if (isset($data['multilanguage'])) {
                    if($data['multilanguage']=='on'){
                    $data['multilanguage'] = 1;
                    }else{
                    $data['multilanguage'] = $data['multilanguage'];
                    }
                }else{
                    $data['multilanguage'] = 0;
                }

                 if (isset($data['shipping_discount'])) {
                    if($data['shipping_discount']=='on'){
                    $data['shipping_discount'] = 1;
                    }else{
                    $data['shipping_discount'] = $data['shipping_discount'];
                    }
                }else{
                    $data['shipping_discount'] = 0;
                }

                if (isset($data['multicurrency'])) {
                    if($data['multicurrency']=='on'){
                    $data['multicurrency'] = 1;
                    }else{
                    $data['multicurrency'] = $data['multicurrency'];
                    }
                }else{
                    $data['multicurrency'] = 0;
                }
            }


            if($page_name=='push-notification-setting'){

                if (isset($data['enable_notifications'])) {
                    if($data['enable_notifications']=='on'){
                    $data['enable_notifications'] = 1;
                    }else{
                    $data['enable_notifications'] = $data['enable_notifications'];
                    }
                }else{
                    $data['enable_notifications'] = 0;
                }

                $push_data = $obj::where('key', 'one_signal_key')->first();
                $one_signal_key = $push_data->value;

                // Check if the last 5 characters match
                if (substr($one_signal_key, -5) == substr($data['one_signal_key'], -5)) {
                    $data['one_signal_key'] = $one_signal_key;
                }
                $push_data = $obj::where('key', 'one_signal_app_id')->first();
                $one_signal_app_id = $push_data->value;
                
                // Check if the last 5 characters match
                if (substr($one_signal_app_id, -5) == substr($data['one_signal_app_id'], -5)) {
                    $data['one_signal_app_id'] = $one_signal_app_id;
                }

                $push_data = $obj::where('key', 'firebase_msg_key')->first();
                $firebase_msg_key = $push_data->value;

                // Check if the last 5 characters match
                if (substr($firebase_msg_key, -5) == substr($data['firebase_msg_key'], -5)) {
                    $data['firebase_msg_key'] = $firebase_msg_key;
                }
                $push_data = $obj::where('key', 'firebase_api_key')->first();
                $firebase_api_key = $push_data->value;
                
                // Check if the last 5 characters match
                if (substr($firebase_api_key, -5) == substr($data['firebase_api_key'], -5)) {
                    $data['firebase_api_key'] = $firebase_api_key;
                }
            }


            if($page_name=='sms-setting'){

                if (isset($data['is_enable_twilio'])) {
                    if($data['is_enable_twilio']=='on'){
                    $data['is_enable_twilio'] = 1;
                    }else{
                    $data['is_enable_twilio'] = $data['is_enable_twilio'];
                    }
                }else{
                    $data['is_enable_twilio'] = 0;
                }

                if (isset($data['is_enable_msg91'])) {
                    if($data['is_enable_msg91']=='on'){
                    $data['is_enable_msg91'] = 1;
                    }else{
                    $data['is_enable_msg91'] = $data['is_enable_msg91'];
                    }
                }else{
                    $data['is_enable_msg91'] = 0;
                }
            }


               if($page_name=='tax-setting'){

                if (isset($data['excluding_tax'])) {
                    if($data['excluding_tax']=='on'){
                    $data['excluding_tax'] = 1;
                    }else{
                    $data['excluding_tax'] = $data['excluding_tax'];
                    }
                }else{
                    $data['excluding_tax'] = 0;
                }

                if (isset($data['including_tax'])) {
                    if($data['including_tax']=='on'){
                    $data['including_tax'] = 1;
                    }else{
                    $data['including_tax'] = $data['including_tax'];
                    }
                }else{
                    $data['including_tax'] = 0;
                }
            }

            if($page_name == 'maintainance-setting'){
               
                if (isset($data['enable_maintainance_mode'])) {
                    if($data['enable_maintainance_mode']=='on'){
                    $data['enable_maintainance_mode'] = 1;
                    }else{
                    $data['enable_maintainance_mode'] = $data['enable_maintainance_mode'];
                    }
                }else{
                    $data['enable_maintainance_mode'] = 0;
                }
            }

            if($page_name=='company-setting'){

                if (isset($data['is_include_tax_amount_enable'])) {
                    if($data['is_include_tax_amount_enable']=='on'){
                    $data['is_include_tax_amount_enable'] = 1;
                    }else{
                    $data['is_include_tax_amount_enable'] = $data['is_include_tax_amount_enable'];
                    }
                }else{
                    $data['is_include_tax_amount_enable'] = 0;
                }

                if (isset($data['is_order_notification_for_admin_enable'])) {
                    if($data['is_order_notification_for_admin_enable']=='on'){
                    $data['is_order_notification_for_admin_enable'] = 1;
                    }else{
                    $data['is_order_notification_for_admin_enable'] = $data['is_order_notification_for_admin_enable'];
                    }
                }else{
                    $data['is_order_notification_for_admin_enable'] = 0;
                }

                if (isset($data['is_service_charge_enable'])) {
                    if($data['is_service_charge_enable']=='on'){
                    $data['is_service_charge_enable'] = 1;
                    }else{
                    $data['is_service_charge_enable'] = $data['is_service_charge_enable'];
                    }
                }else{
                    $data['is_service_charge_enable'] = 0;
                }

                if (isset($data['is_partial_payment_enable'])) {
                    if($data['is_partial_payment_enable']=='on'){
                    $data['is_partial_payment_enable'] = 1;
                    }else{
                    $data['is_partial_payment_enable'] = $data['is_partial_payment_enable'];
                    }
                }else{
                    $data['is_partial_payment_enable'] = 0;
                }

                if (isset($data['is_can_pay_the_rest_amount_using_enable'])) {
                    if($data['is_can_pay_the_rest_amount_using_enable']=='on'){
                    $data['is_can_pay_the_rest_amount_using_enable'] = 1;
                    }else{
                    $data['is_can_pay_the_rest_amount_using_enable'] = $data['is_can_pay_the_rest_amount_using_enable'];
                    }
                }else{
                    $data['is_can_pay_the_rest_amount_using_enable'] = 0;
                }

                if (isset($data['is_free_delivery_distance_enable'])) {
                    if($data['is_free_delivery_distance_enable']=='on'){
                    $data['is_free_delivery_distance_enable'] = 1;
                    }else{
                    $data['is_free_delivery_distance_enable'] = $data['is_free_delivery_distance_enable'];
                    }
                }else{
                    $data['is_free_delivery_distance_enable'] = 0;
                }
            }

            
            // Here we are inserting data into the database
            foreach ($data as $key => $value) {
                $exist = $obj->where('key',$key)->first();
                if ($exist) {
                    $id = $obj->where('id',$exist->id)->update(array('value'=>$value));
                }else{
                    $obj->insert(array('key'=>$key,'value'=>$value));
                }
            }

            $settingsc = $obj->all();
            foreach ($settingsc as $row) {
                ContentSetting::set($row->key, $row->value);
            }
            ContentSetting::save();


            return ['status' => true, 'message' => __('lang.admin_data_update_msg')];
        }

      }catch (\Exception $e) 
      {
         return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
      }
   }   

}
