<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;  
use App\Models\User;  

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

      // user part start here
  public function userforgotpassword(Request $request)
{
  
   return view('website.forgotpassword');
}

  

    public function userforgetPasswordPost(Request $request)
    {   
        $user = User::doForgetPassword($request->all());
        if($user['status']==true){

            
     return redirect()->to(url('user-reset-password-show'))->with('success', $user['message']);

        }
        else{
            return redirect()->back()->withInput($request->only('email'))->with('error', $user['message']);
        }   
    }


      public function user_reset_password(Request $request)
{
      
   return view('website.resetpassword');
}

  public function userreset_PasswordPost(Request $request)
    {   
        
        $data = User::userResetPassword($request->all());
        if($data['status']==true){
          
    return redirect()->to(url('user-login'))->with('success', 'password reset successfully');
        }
        else{
            return redirect()->back()->withInput($request->only('email'))->with('error', $data['message']);
        }   
    }

    // user part end here



    // Admin and seller forgot password start here

public function forgotpassword(Request $request)
{
      
   return view('admin.forgotpasword.index');
}


 public function forgetPasswordPost(Request $request)
    {   
        $user = User::admin_sellerForgetPassword($request->all());
        if($user['status']==true){

            
     return redirect()->to(url('reset-password-show'))->with('success', $user['message']);

        }
        else{
            return redirect()->back()->withInput($request->only('email'))->with('error', $user['message']);
        }   
    }

 public function resetpassword(Request $request)
{
      
   return view('admin.forgotpasword.resetpassword');
}

public function reset_PasswordPost(Request $request)
{
    $data = User::admin_sellerResetPassword($request->all());

    if ($data['status'] == true) {
        if ($data['type'] == 'admin') {
            return redirect()->to(url('admin-login'))->with('success', 'Password reset successfully');
        } elseif ($data['type'] == 'seller') {
            return redirect()->to(url('seller-login'))->with('success', 'Password reset successfully');
        }
    } else {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', $data['message']);
    }
}


   
}
