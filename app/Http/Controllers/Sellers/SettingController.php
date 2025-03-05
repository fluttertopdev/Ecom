<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as ContentSetting;
use App\Models\Setting;
use App\Models\Sellers;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Models\Taxinfo;
use App\Models\Bankinfo;
use App\Models\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Auth;

class SettingController extends Controller
{
    





    public function index()
    {
      
      
       $id = Auth::guard('seller')->user()?->id ?? null;
      
       
   
   
   $data['taxinfo'] = Taxinfo::where('userid', $id)->first();
    $data['bankinfo'] = Bankinfo::where('userid', $id)->first();
   
    
    $data['loactionsettings'] = User::where('id', $id)->first();
    $data['country_data'] = Country::get();
    $data['state_data'] = State::where('countryid', $data['loactionsettings']->countryid)->get();
    $data['city_data'] = City::where('stateid', $data['loactionsettings']->stateid)->get();
  

 
        return view('sellers.setting.index',$data);
    }



         public function countrychange(Request $request)
{
    
    $category_id = $request->input('category_id');


    

     
   
     $statename = State::where('countryid', $category_id)->get();

    

   

    // Return a response if needed
    return response()->json([
        'success' => true,
        'statename' => $statename
    ]);
}


public function statechange(Request $request)
{
    $stateId = $request->input('state_id');

    // Fetch cities based on state ID
    $cities = City::where('stateid', $stateId)->get();

    return response()->json([
        'success' => true,
        'cities' => $cities
    ]);
}




  public function update(Request $request)
{   

 
    // Get the authenticated seller's ID
        $id = Auth::check() && Auth::user()->type == 'seller' ? Auth::user()->id : null;

  

    
    $seller = User::find($id);
     

    if ($seller) {
      
        $seller->name = $request->input('name');
        $seller->email = $request->input('email');
        $seller->phone = $request->input('phone');
        $seller->countryid = $request->input('country');
        $seller->stateid = $request->input('state');
        $seller->cityid = $request->input('city');
        $seller->address = $request->input('address');
        $seller->description = $request->input('description');
        $seller->save(); // Save the updated data to the database

       
         return redirect()->back()->with('success', 'Seller Details updated successfully.');
     
    } else {
        // Redirect back with an error message if the seller is not found
        return redirect()->back()->with('error', 'Seller not found.');
    }
}


 public function updatetaxinfo(Request $request)
{   
    // Get the authenticated seller's ID
     $id = Auth::check() && Auth::user()->type == 'seller' ? Auth::user()->id : null;

    

    // Check if Taxinfo exists for the seller
    $Taxinfo = Taxinfo::where('userid', $id)->first();

    if ($Taxinfo) {
        // Update the existing Taxinfo
        $Taxinfo->business_name = $request->input('business_name');
        $Taxinfo->taxid = $request->input('tax');
        $Taxinfo->pan = $request->input('pan');
        $Taxinfo->userid = $id;
        $Taxinfo->save();

        return redirect()->back()->with('success', 'Tax Info updated successfully.');
    } else {
        // Create a new Taxinfo record if none exists
        $Taxinfo = new Taxinfo;
        $Taxinfo->business_name = $request->input('business_name');
        $Taxinfo->taxid = $request->input('tax');
        $Taxinfo->pan = $request->input('pan');
        $Taxinfo->userid = $id;
        $Taxinfo->save();

        return redirect()->back()->with('success', 'Tax Info added successfully.');
    }
}

 public function updatebankinfo(Request $request)
{   


   
    // Get the authenticated seller's ID
    $id = Auth::guard('seller')->user()->id;

    

    // Check if Taxinfo exists for the seller
    $Bankinfo = Bankinfo::where('userid', $id)->first();
  
    if ($Bankinfo) {
       
        $Bankinfo->bank_name = $request->input('bank_name');
        $Bankinfo->ifsccode = $request->input('ifsccode');
        $Bankinfo->holdername = $request->input('holdername');
        $Bankinfo->accountno = $request->input('accountno');
        $Bankinfo->upiid = $request->input('upiid');
        $Bankinfo->userid = $id;
        $Bankinfo->save();

        return redirect()->back()->with('success', 'Bank Info updated successfully.');
    } else {
         $Bankinfo = new Bankinfo;
        $Bankinfo->bank_name = $request->input('bank_name');
        $Bankinfo->ifsccode = $request->input('ifsccode');
        $Bankinfo->holdername = $request->input('holdername');
        $Bankinfo->accountno = $request->input('accountno');
        $Bankinfo->upiid = $request->input('upiid');
        $Bankinfo->userid = $id;
        $Bankinfo->save();

        return redirect()->back()->with('success', 'Bank Info added successfully.');
    }
}



  public function commissionhistory()
    {
      
    return view('sellers.sellers.commissionhistory');
    }



  public function sellersetLanguage(Request $request){
        $post = $request->all();
        if (array_key_exists($post['lang'], Config::get('languages'))) {
            if (isset($post['lang'])) {
              
                App::setLocale($post['lang']);
                Session::put('seller_locale', $post['lang']);
                setcookie('seller_lang_code',$post['lang'],time()+60*60*24*365);
            }
        }
        return redirect()->back();
    }












}
