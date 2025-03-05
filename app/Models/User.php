<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Mail\ExampleMail;
use Illuminate\Support\Facades\Mail;
use DB;

use Illuminate\Support\Facades\Hash;






class User extends Authenticatable
{
use HasApiTokens, HasFactory, Notifiable,HasRoles;
use SoftDeletes;

protected $guarded = ['id'];
protected $table = "users";




public function coupons()
{
return $this->belongsToMany(Coupon::class, 'coupon_customers', 'customer_id', 'coupon_id');
}

public function wallets()
{
return $this->hasMany(Wallet::class, 'customer_id');
}


public function orders()
{
return $this->hasMany(Order::class);
}

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



/**
* The attributes that are mass assignable.
*
* @var array<int, string>
*/
protected $fillable = [
'name',
'email',
'password',
'status',
'api_token',
'created_type',
'countryid',
'stateid',
'cityid',
'type',
'phone',
'role_id',
'address',
'description',
];


/**
* The attributes that should be hidden for serialization.
*
* @var array<int, string>
*/
protected $hidden = [
'password',
'remember_token',
];

/**
* The attributes that should be cast.
*
* @var array<string, string>
*/
protected $casts = [
'email_verified_at' => 'datetime',
];


/**
* admin Login
**/
public static function adminLogin($data){
   
try {
$obj = new Self;
$credentials = [
'email' => $data['email'],
'password' => $data['password'],
];
$user = $obj->where('email', $data['email'])->where('type', 'admin')->first();
if ($user) {
if($user->status != 1){
return ['status' => false, 'message' => config('constant.common.messages.your_account_has_been_suspended')];
}
if (Auth::attempt($credentials)) {
return ['status' => true, 'message' => __('lang.admin_welcome_msg')];
}else{
if ($obj->where('email', $data['email'])->exists()) {
return ['status' => false, 'message' => __('lang.admin_incorrect_password')];
}
return ['status' => false, 'message' => __('lang.admin_invalid_email_password')];
}
}else{
return ['status' => false, 'message' => __('lang.admin_invalid_email_password')];
}
}
catch (\Exception $e) {
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}

/**
* Admin Forget Password
**/


/**
* Fetch particular admin profile detail
**/
public static function getProfile()
{
try 
{
$obj = new self;
$id = Auth::user()->id;
$data = $obj->where('id',$id)->firstOrFail();
return $data;
}
catch (\Exception $e) 
{
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}

/**
* Update admin profile
**/
public static function updateProfile($data,$id) 
{
try 
{
$obj = new self;
unset($data['_token']);
if(isset($data['image']) && $data['image']!=''){
$uploadImage = \Helpers::uploadFiles($data['image'],'user/');
if($uploadImage['status']==true){
$data['image'] = $uploadImage['file_name'];
}
}
if (empty($data['password'])) 
{
unset($data['password']);
} 
else 
{
$data['password'] = Hash::make($data['password']);
}
$data['updated_at'] = date('Y-m-d H:i:s');
$obj->where('id',$id)->update($data);
return ['status' => true, 'message' => __('lang.admin_data_update_msg')];
}
catch (\Exception $e) 
{
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}

}


/**
* Fetch list from here
**/
public static function getCustomerLists($search)
{
try {

$obj = new self;

$pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');

if(isset($search['name']) && !empty($search['name'])){
$obj = $obj->orWhere('name', 'like', '%'.trim($search['name']).'%')
->orWhere('email', 'like', '%'.trim($search['name']).'%');
} 

if(isset($search['status']) && $search['status']!=''){
$obj = $obj->where('status',$search['status']);
} 

$data = $obj->where('type','customer')->orderBy('id', 'DESC')->paginate($pagination)->appends('perpage', $pagination);

return $data;
}
catch (\Exception $e) {
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}


/**
* Add or update record
**/
public static function addUpdate($data,$id=0) {

try{
$obj = new self;
unset($data['_token']);
if(isset($data['image']) && $data['image']!=''){
$uploadImage = \Helpers::uploadFiles($data['image'],'user/');
if($uploadImage['status']==true){
$data['image'] = $uploadImage['file_name'];
}
}
if(isset($data['password']) && $data['password']!=''){
$data['password'] = Hash::make($data['password']);
}

if($id==0){
$data['created_at'] = date('Y-m-d H:i:s');
$data['type'] = "subadmin";
$entry_id = $obj->insertGetId($data);
$user= User::find($entry_id);
$role = Role::where('id',$data['role_id'])->first();
$permissions = DB::table('role_has_permissions')->where('role_id',$data['role_id'])->pluck('permission_id')->all();
$role->syncPermissions($permissions);
$user->assignRole([$data['role_id']]);
return ['status' => true, 'message' => 'Data added successfully.'];
}
else{
$data['updated_at'] = date('Y-m-d H:i:s');
$obj->where('id',$id)->update($data);
return ['status' => true, 'message' => "Data updated successfully."];
}
}catch (\Exception $e) {
dd($e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile());
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}


/**
* Add or update record
**/
public static function addUpdateCustomer($data,$id=0) {

try{
$obj = new self;
unset($data['_token']);
if(isset($data['image']) && $data['image']!=''){
$uploadImage = \Helpers::uploadFiles($data['image'],'user/');
if($uploadImage['status']==true){
$data['image'] = $uploadImage['file_name'];
}
}
if(isset($data['password']) && $data['password']!=''){
$data['password'] = Hash::make($data['password']);
}
if($id==0){
$data['created_at'] = date('Y-m-d H:i:s');
$data['type'] = "customer";
$entry_id = $obj->insertGetId($data);
$user= User::find($entry_id);
return ['status' => true, 'message' => 'Data added successfully.'];
}
else{
$data['updated_at'] = date('Y-m-d H:i:s');
$obj->where('id',$id)->update($data);
return ['status' => true, 'message' => "Data updated successfully."];
}
}catch (\Exception $e) {
dd($e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile());
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}

/**
* Delete particular record
**/
public static function deleteRecord($id) {
try {
$obj = new self;    
$obj->where('id',$id)->delete();   
return ['status' => true, 'message' => __('lang.admin_data_delete_msg')];
}
catch (\Exception $e) {
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}

/**
* Update Columns 
**/
public static function updateColumn($id){
try {
$data = self::where('id', $id)->first();

// Assuming 'status' is an ENUM column with values '0' and '1'
$newStatus = ($data->status == '1') ? '0' : '1';

$data->update(['status' => $newStatus]);

return ['status' => true, 'message' => __('lang.admin_data_change_msg')];
} catch (\Exception $e) {
return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
}
}


/**
* Fetch list of subadmin from here
**/
public static function getSubadminList($search){
try 
{
$obj = new self;
$pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');
if(isset($search['search']) && !empty($search['search']))
{
$keyword = $_GET['search'];
$obj = $obj->where(function($q) use ($keyword){
$q->where(DB::raw('LOWER(name)'), 'like', '%'.strtolower($keyword). '%')
->orWhere(DB::raw('email'),'like','%'.strtolower($keyword). '%');
});
}         
if(isset($search['status']) && $search['status']!='')
{
$obj = $obj->where('status',$search['status']);
}

$data = $obj->where('type','subadmin')->latest('created_at')->paginate($pagination)->appends('perpage', $pagination);
return $data;
}
catch (\Exception $e) 
{
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}





// this is for user 

public static function userLogin($data){
try {
$obj = new Self;
$credentials = [
'email' => $data['email'],
'password' => $data['password'],
];
$user = $obj->where('email',$data['email'])->where('type', 'customer')->first();
if ($user) {
if($user->status != 1){
return ['status' => false, 'message' => config('constant.common.messages.your_account_has_been_suspended')];
}
if (Auth::attempt($credentials)) {
return ['status' => true, 'message' => __('lang.admin_welcome_msg')];
}else{
if ($obj->where('email', $data['email'])->exists()) {
return ['status' => false, 'message' => __('lang.admin_incorrect_password')];
}
return ['status' => false, 'message' => __('lang.admin_invalid_email_password')];
}
}else{
return ['status' => false, 'message' => __('lang.admin_invalid_email_password')];
}
}
catch (\Exception $e) {
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}





// this is for sellers 
public static function addUpdatesellers($data,$id=0) {



try {
$obj = new self;
unset($data['_token']);



if(isset($data['image']) && $data['image']!=''){
$uploadImage = \Helpers::uploadFiles($data['image'],'sellers/');
if($uploadImage['status']==true){
$data['image'] = $uploadImage['file_name'];
}
}


if(isset($data['password']) && $data['password']!=''){
$data['password'] = Hash::make($data['password']);
}

if($id==0){


$data['created_at'] = date('Y-m-d H:i:s');
$category_id = $obj->insertGetId($data);
return ['status' => true, 'message' => __('lang.admin_data_add_msg')];
}
else{


$data['updated_at'] = date('Y-m-d H:i:s');
$obj->where('id',$id)->update($data);
return ['status' => true, 'message' => __('lang.admin_data_update_msg')];
}  
}
catch (\Exception $e) {
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}



public static function sellersgetLists($search){
try {


$obj = new self;

$pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');
$obj = $obj->where('type', 'seller');

if(isset($search['name']) && !empty($search['name'])){
$obj = $obj->where('name', 'like', '%'.trim($search['name']).'%');
} 


if(isset($search['status']) && $search['status']!=''){
$obj = $obj->where('status',$search['status']);
} 



$data = $obj->orderBy('id', 'DESC')->paginate($pagination)->appends('perpage', $pagination);



return $data;
}
catch (\Exception $e) {
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}


public static function sellerLogin($data){
try {

   
$obj = new Self;
$credentials = [
'email' => $data['email'],
'password' => $data['password'],
];
$user = $obj->where('email', $data['email'])->where('type', 'seller')->first();


if ($user) {
if($user->status != 1){
return ['status' => false, 'message' => config('constant.common.messages.your_account_has_been_suspended')];
}
if (Auth::attempt($credentials)) {
return ['status' => true, 'message' => __('lang.admin_welcome_msg')];
}else{
if ($obj->where('email', $data['email'])->exists()) {
return ['status' => false, 'message' => __('lang.admin_incorrect_password')];
}
return ['status' => false, 'message' => __('lang.admin_invalid_email_password')];
}
}else{
return ['status' => false, 'message' => __('lang.admin_invalid_email_password')];
}
}
catch (\Exception $e) {
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}





// user forgot password 
public static function doForgetPassword($data){
try {
$obj = new Self;


$credentials=$data['email'];


$user = $obj->where('email', $data['email'])
            ->where('type', $data['type']) 
            ->first();
if ($user) {
if($user){
$otp = rand(1000,9999);             
 $details = [
        'subject' => 'Forgot Password',
         'message' => 'We received a request to reset your password. Your OTP is ' . $otp, 
    ];

//Todo Email
   Mail::to($credentials)->send(new ExampleMail($details));
User::where('id',$user->id)->update(['otp'=>$otp]);

return ['status' => true, 'data' => $data, 'message' => __('lang.message_otp_sent_success')];
}
}else{
return ['status' => false, 'message' => __('lang.message_user_not_found')];
}
}
catch (\Exception $e) {
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}

public static function userResetPassword($data){
$obj = new Self;
$credentials = [
'otp' => $data['otp'],
'password' => $data['password'],
'cpassword' => $data['cpassword'],
];
$user = $obj->where('otp',$data['otp'])->where('type' ,'customer')->first();
if ($user) {
if($user){
$inject = array();
if($data['password'] && $data['password'] != ''){
$inject['password'] = bcrypt($data['password']);
$inject['otp'] = 0;
}
User::where('id',$user->id)->update($inject);
return ['status' => true, 'data' => $user, 'message' => 'password reset successfully'];
}
}else{
return ['status' => false, 'message' => 'Worng OTP '];
}

}

// admin and seller forgot password start here 
// user forgot password 
public static function admin_sellerForgetPassword($data){
try {
$obj = new Self;


$credentials=$data['email'];


$user = $obj->where('email', $data['email'])
            ->where('type','!=','customer') 
            ->first();

if ($user) {
if($user){
$otp = rand(1000,9999);             
 $details = [
        'subject' => 'Forgot Password',
         'message' => 'We received a request to reset your password. Your OTP is ' . $otp, 
    ];

//Todo Email
   Mail::to($credentials)->send(new ExampleMail($details));
User::where('id',$user->id)->update(['otp'=>$otp]);

return ['status' => true, 'data' => $data, 'message' => __('lang.message_otp_sent_success')];
}
}else{
return ['status' => false, 'message' => __('lang.message_user_not_found')];
}
}
catch (\Exception $e) {
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}
}
public static function admin_sellerResetPassword($data){
$obj = new Self;
$credentials = [
'otp' => $data['otp'],
'password' => $data['password'],
'cpassword' => $data['cpassword'],
];
$user = $obj->where('otp',$data['otp'])->first();
$type=$user->type;
if ($user) {
if($user){
$inject = array();
if($data['password'] && $data['password'] != ''){
$inject['password'] = bcrypt($data['password']);
$inject['otp'] = 0;
}
User::where('id',$user->id)->update($inject);
return ['status' => true, 'data' => $user, 'message' => 'password reset successfully','type'=>$type];
}
}else{
return ['status' => false, 'message' => 'Worng OTP '];
}

}

/**
* Update admin profile
**/
public static function sellerupdateProfile($data,$id) 
{
try 
{
$obj = new self;
unset($data['_token']);
if(isset($data['image']) && $data['image']!=''){
$uploadImage = \Helpers::uploadFiles($data['image'],'sellers/');
if($uploadImage['status']==true){
$data['image'] = $uploadImage['file_name'];
}
}
if (empty($data['password'])) 
{
unset($data['password']);
} 
else 
{
$data['password'] = Hash::make($data['password']);
}
$data['updated_at'] = date('Y-m-d H:i:s');
$obj->where('id',$id)->update($data);
return ['status' => true, 'message' => __('lang.admin_data_update_msg')];
}
catch (\Exception $e) 
{
return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
}

}




}
