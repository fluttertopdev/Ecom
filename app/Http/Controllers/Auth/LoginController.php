<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Sellers;
use App\Models\RoleHasPermission;
use App\Models\Permission;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Session;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
  

    /**
     * Show specified view.
     *
     * @return void
    */
    public function getLoginView(Request $request)
    { 
        return view('admin.auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
    */

    



       public function authenticate(Request $request)
{
    $credentials = $request->only('email', 'password');
    
    if (Auth::guard('admin')->attempt($credentials)) {
        $user = Auth::guard('admin')->user();
          
        // Check if the logged-in user is a seller
        if ($user->type == 'admin') {
           $roleid = $user->role_id;
           $permissionIds = RoleHasPermission::where('role_id', $roleid)->pluck('permission_id')->toArray();
           $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
           Session::put('permissions', $permissionNames);
           
            return redirect('admin/dashboard')->with('success', 'Login Successful.');
        } else {
            // If the user is not a seller, log them out and return an error
            Auth::guard('admin')->logout();
            return redirect()->back()->with('error', 'Invalid credentials.');
        }
    }

    return redirect()->back()->with('error', 'Invalid credentials');
}




 public function getallPermissions(Request $request)
    { 

        $user = Auth::guard('admin')->user();
       
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
  
   public function adminlogout(Request $request)
{
    Auth::guard('admin')->logout();
    $request->session()->forget('admin'); // Forget only the admin session data
    return redirect(url('admin-login'));
}





// this is for sellers login 
     public function getSellersLoginView(Request $request)
    { 

      
        return view('sellers.auth.sellerLogin');
    }




   public function doSellerLogin(Request $request)
{
    $credentials = $request->only('email', 'password');
    
    if (Auth::guard('seller')->attempt($credentials)) {
        $user = Auth::guard('seller')->user();
        
        // Check if the logged-in user is a seller
        if ($user->type == 'seller') {
             $roleid = $user->role_id;
           $permissionIds = RoleHasPermission::where('role_id', $roleid)->pluck('permission_id')->toArray();
           $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
           Session::put('sellerpermissions', $permissionNames);
            return redirect('seller-dashboard')->with('success', 'Login Successful.');
        } else {
            // If the user is not a seller, log them out and return an error
            Auth::guard('seller')->logout();
            return redirect()->back()->with('error', 'Invalid credentials.');
        }
    }

    return redirect()->back()->with('error', 'Invalid credentials');
}


  


















}
