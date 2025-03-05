<?php

namespace App\Http\Controllers\Sellers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Setting;
use App\Models\Sellers;
use App\Models\User;

use App\Models\Shippingrate_type;
use App\Models\ShippingRate;
use Session;
use DB;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
   



   
   


    



  
    public function updateColumn($id)
    {
        try{
            $updated = Shipping::updateColumn($id);
            if($updated['status']==true){
                return redirect()->back()->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }













 






public function shippingrate(Request $request)
    {

       
        try{
            $data['result'] = Shippingrate_type::get();
           $data['statusTypes'] = \Helpers::getStatusType();
            return view('sellers.shippingrates.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }



  public function updatestatus($id)
    {
        try{
            $updated = Shippingrate_type::updateColumn($id);


            if($updated['status']==true){
                return redirect()->back()->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }






      public function shippingrates(Request $request)
    {
         
          
          
           $userId = Auth::guard('seller')->user()?->id ?? null;
         $localshippingRate = ShippingRate::where('user_id', $userId)
        ->where('location_type', 'local')->where('type', 'per-order')
        ->first();
        $featchcityid = User::where('id', $userId)->value('cityid');
       $featchcityname = City::where('id', $featchcityid)->first();

        $featchstateid = User::where('id', $userId)->value('stateid');
        $featchstatename = State::where('id', $featchstateid)->first();
        $countryid = User::where('id', $userId)->value('countryid');
        $countryname = Country::where('id', $countryid)->first();
    



 $citiesdata = DB::table('shippingrate')
    ->join('cities', 'shippingrate.cityid', '=', 'cities.id')
    ->join('states', 'cities.stateid', '=', 'states.id')
    ->select(
        'shippingrate.id as shippingrate_id',
        'shippingrate.cityid as cityid',
        'cities.name as city_name',
        'states.name as state_name',
        'shippingrate.transittime',
        'shippingrate.rate',
        'shippingrate.freeshipping'
    )
    ->where('shippingrate.user_id', $userId)
    ->where('shippingrate.location_type', 'regional')
   ->where('cities.id', '!=', $featchcityid)
   
    ->get();


 $nationalshipping = DB::table('shippingrate')
    ->join('states', 'shippingrate.stateid', '=', 'states.id') // Directly join states
    ->join('countries', 'states.countryid', '=', 'countries.id') // Join with countries table
    ->select(
        'shippingrate.id as shippingrate_id',
        'shippingrate.stateid as stateid',
        'states.name as state_name',
        'countries.name as country_name', // Select country name
        'shippingrate.transittime',
        'shippingrate.rate',
         'shippingrate.freeshipping'
    )
    ->where('shippingrate.user_id', $userId)
    ->where('shippingrate.location_type', 'national')
    
    ->get();



            return view('sellers.shippingrates.shippingrate',compact('localshippingRate','featchcityname','featchstatename','countryname','citiesdata','nationalshipping'));
    
        
    }

public function shippingrateupdate(Request $request)
{

  $userid = Auth::guard('seller')->user()?->id ?? null;
    
    // Check if the shipping rate record exists for the user
    // Check if the shipping rate record exists for the user
    $shippingRate = ShippingRate::where('id', $request->shippingrateid)->first();

    if ($shippingRate) {
        // If the record exists, update it
        $shippingRate->rate = $request->shippingFee;
        $shippingRate->transittime = $request->transitTime;
        $shippingRate->type = $request->ratemode;
        $shippingRate->location_type = $request->rateType;
        $shippingRate->freeshipping = $request->freeshipping;
      
           $shippingRate->user_id = $userid;
        $shippingRate->save();

        return response()->json(['message' => 'Shipping rate updated successfully!']);
    } else {
        
        // If the record does not exist, create a new one
        ShippingRate::create([
            'user_id' => $userid,
            'rate' => $request->shippingFee,
            'transittime' => $request->transitTime,
            'type' => $request->ratemode,
            'location_type' => $request->rateType,
            'freeshipping' => $request->freeshipping,
        
        ]);
        
        return response()->json(['message' => 'Shipping rate created successfully!']);
    }
}




   public function editshippingrate(Request $request)
    {
     
   
            
           $userId = Auth::guard('seller')->user()?->id ?? null;
   
      $featchcityid = User::where('id', $userId)->value('cityid');

      $featchcityname = City::where('id', $featchcityid)->first();

     
        $featchstateid = User::where('id', $userId)->value('stateid');
        $featchstatename = State::where('id', $featchstateid)->first();


         
         $countryid = Setting::where('key', 'country')->first()->value;
         
      
        $localshippingRate = ShippingRate::where('user_id', $userId)
        ->where('location_type', 'local')->where('type', 'per-order')
        ->first();

       




        $allCities = DB::table('cities')->pluck('id')->toArray();
   
    // Step 2: Get existing city IDs from shippingrate
    $existingCityIds = DB::table('shippingrate')
        ->where('user_id', $userId)
        ->pluck('cityid') // Get the column containing the city IDs
        ->map(function ($cityIds) {
            return explode(',', $cityIds); // Split comma-separated values
        })
        ->flatten() // Flatten the nested arrays into a single array
        ->unique() // Get unique city IDs
        ->toArray();
      
    // Step 3: Filter out the cities that are already present
    $availableCities = array_diff($allCities, $existingCityIds);
  
    // Fetch detailed information about available cities
    $selectedCities = DB::table('cities')
        ->whereIn('id', $availableCities)
        ->where('cities.id', '!=', $featchcityid)
         ->where('stateid', $featchstateid)

        ->select('id', 'name') // Select the fields you want
        ->get();

  
     


     // Step 1: Get all state IDs from the 'states' table
$allStates = DB::table('states')->pluck('id')->toArray();

// Step 2: Get existing state IDs from 'shippingrate' where location_type = 'national'
$existingStateIds = DB::table('shippingrate')
    ->where('location_type', 'national') // Condition for national shipping rates
    ->where('user_id', $userId)
    ->pluck('stateid') // Assuming 'stateid' column exists in the 'shippingrate' table
    ->map(function ($stateIds) {
        return explode(',', $stateIds); // Split comma-separated values
    })
    ->flatten() // Flatten the nested arrays into a single array
    ->unique() // Get unique state IDs
    ->toArray();

// Step 3: Filter out the states that are already present in 'shippingrate'
$availableStates = array_diff($allStates, $existingStateIds);



// Step 4: Fetch detailed information about available states
$selectedStates = DB::table('states')
    ->whereIn('id', $availableStates)
    ->where('states.id', '!=', $featchstateid) // Exclude a specific state if needed
    ->select('id', 'name') // Select the fields you want
    ->get();

     $citiesdata = DB::table('shippingrate')
    ->join('cities', 'shippingrate.cityid', '=', 'cities.id')
    ->join('states', 'cities.stateid', '=', 'states.id')
    ->select(
        'shippingrate.id as shippingrate_id',
        'shippingrate.cityid as cityid',
        'cities.name as city_name',
        'states.name as state_name',
        'shippingrate.transittime',
        'shippingrate.rate',
        'shippingrate.freeshipping'
    )
    ->where('shippingrate.user_id', $userId)
     ->where('shippingrate.location_type', 'regional')
   ->where('cities.id', '!=', $featchcityid)
   
    ->get();




    $nationalshipping = DB::table('shippingrate')
    ->join('states', 'shippingrate.stateid', '=', 'states.id') // Directly join states
    ->join('countries', 'states.countryid', '=', 'countries.id') // Join with countries table
    ->select(
        'shippingrate.id as shippingrate_id',
        'shippingrate.stateid as stateid',
        'states.name as state_name',
        'countries.name as country_name', // Select country name
        'shippingrate.transittime',
        'shippingrate.rate',
        'shippingrate.freeshipping'
    )
    ->where('shippingrate.user_id', $userId)
    ->where('shippingrate.location_type', 'national')
    
    ->get();
   

   
    return view('sellers.shippingrates.editshippingrate',compact('featchcityname','featchstatename','localshippingRate','selectedCities','citiesdata','nationalshipping','selectedStates'));
    
        
    }




public function addnewcity(Request $request)
{
    
     $userid = Auth::guard('seller')->user()?->id ?? null;
    // Get the array of city IDs
    $cityIds = $request->input('cityIds');
    
    



     
       $userid = Auth::guard('seller')->user()?->id ?? null;
    if (!empty($cityIds)) {
        // Convert the city IDs array into a comma-separated string
        $cityIdsString = implode(',', $cityIds);

        // Insert the data into the 'cityenables' table
        DB::table('shippingrate')->insert([
            'user_id' => $userid,
            'cityid' => $cityIdsString,
            'stateid'=>$request->stateid,
             'location_type'=>'regional'
        ]);
    }

    // Optionally, return a response or redirect
    return redirect()->back()->with('success', 'Cities added successfully!');
}


public function geteditcity(Request $request)
{
    $editid = $request->input('editid');

    
    $shippingRate = ShippingRate::find($editid);
   
    
    if ($shippingRate) {
        
        $cityIds = explode(',', $shippingRate->cityid); 

        // Fetch the cities based on the IDs
        $cities = City::whereIn('id', $cityIds)->get();


        return response()->json(['cities' => $cities]);
    }

    
    return response()->json(['cities' => []]);
}






public function updateforshippingcity(Request $request)
{
    // Get the edit ID and city IDs from the request
    $editid = $request->input('editid');
    $cityIds = $request->input('cityIds');

    // Ensure cityIds is an array
    if (!is_array($cityIds)) {
        $cityIds = $cityIds ? explode(',', $cityIds) : [];
    }

    // Find the ShippingRate model instance by the provided edit ID
    $shippingRate = ShippingRate::find($editid);

    // Check if the shipping rate exists
    if ($shippingRate) {
        // Update the cityid column with the comma-separated city IDs
        $shippingRate->cityid = implode(',', $cityIds);

        // Save the changes
        $shippingRate->save();

        // Optionally, return a response or redirect
        return redirect()->back();
    }

    // Optionally, handle the case where the shipping rate does not exist
    return redirect()->back()->with('error', 'Shipping rate not found.');
}




public function addnewstate(Request $request)
{
    // Get the array of city IDs
    $stateIds = $request->input('stateIds');


    // Get the authenticated user's ID
     $userId = Auth::check() && Auth::user()->type == 'seller' ? Auth::user()->id : null;

    if (!empty($stateIds)) {
        // Convert the city IDs array into a comma-separated string
        $stateIdsString = implode(',', $stateIds);

        // Insert the data into the 'cityenables' table
        DB::table('shippingrate')->insert([
        'location_type' => 'national',
            'user_id' => $userId,
            'stateid'=>$stateIdsString
        ]);
    }

    // Optionally, return a response or redirect
    return redirect()->back()->with('success', 'State added successfully!');
}



public function geteditstate(Request $request)
{
    $editid = $request->input('editid');

    
    $shippingRate = ShippingRate::find($editid);

    
    if ($shippingRate) {
        
        $stateIds = explode(',', $shippingRate->stateid); 

        // Fetch the cities based on the IDs
        $cities = State::whereIn('id', $stateIds)->get();


        return response()->json(['cities' => $cities]);
    }

    
    return response()->json(['cities' => []]);
}






public function updateforshippingstate(Request $request)
{
    // Get the edit ID and city IDs from the request
    $editid = $request->input('editid');
    $cityIds = $request->input('cityIds');

    // Ensure cityIds is an array
    if (!is_array($cityIds)) {
        $cityIds = [$cityIds]; // Wrap in an array if it's a single value
    }

    // Find the ShippingRate model instance by the provided edit ID
    $shippingRate = ShippingRate::find($editid);

    // Check if the shipping rate exists
    if ($shippingRate) {
        // Update the stateid column with the comma-separated city IDs
        $shippingRate->stateid = implode(',', $cityIds);
        
        // Save the changes
        $shippingRate->save();

        // Optionally, return a response or redirect
        return redirect()->back()->with('success', 'State enabled successfully!');
    }

    // Optionally, handle the case where the shipping rate does not exist
    return redirect()->back()->with('error', 'Shipping State not found.');
}



}
