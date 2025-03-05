<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Area;
use App\Models\PushNotification;
use DB;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    /**
     * Display a listing of the blog.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        try{
            $data['result'] = PushNotification::getLists($request->all());
            return view('admin.push-notification.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
    /**
     * Show the form for creating a new notification.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $data['area_data'] = Area::where('status','1')->get();
            $data['sendTo'] = \Helpers::getSendTo();
            return view('admin/push-notification.create',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Send newly created notification to the users.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
           $data = $request->all();
           unset($data['_token']);

            if(isset($data['banner']) && $data['banner']!=''){
                $uploadImage = \Helpers::uploadFiles($data['banner'],'push-notification/');
                if($uploadImage['status']==true){
                    $data['banner'] = $uploadImage['file_name'];
                }
            }

            if(isset($data['schedule_date']) && $data['schedule_date']!=''){
                if(date("Y-m-d H:i:s",strtotime($data['schedule_date'])) > date("Y-m-d H:i:s")){
                    $data['status'] = 0;
                    $data['schedule_date'] = date("Y-m-d H:i:s",strtotime($data['schedule_date']));
                }else{
                  $data['schedule_date'] = date("Y-m-d H:i:s",strtotime($data['schedule_date']));
                }
            }else{
                $data['schedule_date'] = date("Y-m-d H:i:s");
            }  

            $status = PushNotification::insertGetId($data);

            if ($status) {
                return redirect()->back()->with('success', __('lang.message_notification_sent_successfully')); 
            } else {
                return redirect()->back()->with('error', __('lang.message_error_while_sending'));
            }
        }catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Remove the specified resource.
     * @param  Request $request
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        try{
            $deleted = PushNotification::deleteRecord($id);
            if($deleted['status']==true){
                return redirect()->back()->with('success', $deleted['message']); 
            }
            else{
                return redirect()->back()->with('error', $deleted['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
}
