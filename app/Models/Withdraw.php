<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;



class Withdraw extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = "withdrawrequests";

 public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
 
 
public static function withdrawpendinggetLists($search)
{
    try {
        
        $sellersid = Auth::check() && Auth::user()->type == 'seller' ? Auth::user()->id : null;
        $obj = new self;

        $pagination = isset($search['perpage']) ? $search['perpage'] : config('constant.pagination');

        // Add where conditions for user_id and status
        $data = $obj->where('user_id', $sellersid)
                    ->where('status', 'pending') // Change 'pending' to the actual value you need
                    ->orderBy('id', 'DESC')
                    ->paginate($pagination)
                    ->appends('perpage', $pagination);

        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}


public static function allwithdrawgetLists($search)
{
    try {
        
        $sellersid = Auth::check() && Auth::user()->type == 'seller' ? Auth::user()->id : null;
        $obj = new self;

        $pagination = isset($search['perpage']) ? $search['perpage'] : config('constant.pagination');

        // Add where conditions for user_id and status
        $data = $obj->where('user_id', $sellersid)
                    ->where('status', '!=', 'pending') 
                    ->orderBy('id', 'DESC')
                    ->paginate($pagination)
                    ->appends('perpage', $pagination);

        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}

   public static function sellerdisbursementLists($search)
{
    try {
        $obj = new self;

        $pagination = isset($search['perpage']) ? $search['perpage'] : config('constant.pagination');

        // Use eager loading for the related User model
        $data = $obj->with('user') // Assuming 'user' is the relationship method defined in the model
                    ->orderBy('id', 'DESC')
                    ->paginate($pagination)
                    ->appends('perpage', $pagination);

        return $data;
    } catch (\Exception $e) {
        return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
    }
}
   
    public static function addUpdate($data,$id=0) {
      
        try {
            $obj = new self;
            unset($data['_token']);
            
        $userId = Auth::check() && Auth::user()->type == 'seller' ? Auth::user()->id : null;
            $data['user_id'] = $userId;
            $data['status'] = 'pending';
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

    
  


   
   

}
