<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Hash;
use Auth;
use DB;


class Sellers extends Authenticatable
{



    
    use HasFactory;
    use SoftDeletes;
     use Notifiable;
    protected $guarded = ['id'];
    protected $table = "sellers";

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
    public static function getLists($search){
        try {
            
            $obj = new self;

            $pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');

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


   public static function sellerLogin($data)
    {
        try {
            $obj = new Self;
            
            // Find restaurant by email
            $restaurant = $obj->where('email', $data['email'])->first();
            
            if ($restaurant) {
                // Check if the account is active
                if ($restaurant->status != 1) {
                    return ['status' => false, 'message' => __('lang.admin_res_your_account_has_been_suspended')];
                }

                // Manually verify the password
                if (Hash::check($data['password'], $restaurant->password)) {
                    // Login successful, store restaurant in session
                    Auth::guard('seller')->login($restaurant);
                    return ['status' => true, 'message' => __('lang.admin_res_welcome_msg')];
                } else {
                    return ['status' => false, 'message' => __('lang.admin_incorrect_password')];
                }
            } else {
                return ['status' => false, 'message' => __('lang.admin_invalid_email_password')];
            }
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }


  public static function getProfile()
    {
        try 
        {
            $obj = new self;
            $id = Auth::guard('seller')->user()->id;
   
            $data = $obj->where('id',$id)->firstOrFail();
            return $data;
        }
        catch (\Exception $e) 
        {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }



    public static function updateProfile($data,$id) 
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
