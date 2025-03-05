<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\Shippingrate_type;
use App\Models\ShippingRate;
use Session;
use DB;
class ShippingController extends Controller
{
    
   
    public function index(Request $request)
    {




       
        try{
            $data['category_data'] = Category::get();
            $data['country_data'] = Country::get();
            $data['state_data'] = State::where('countryid', $request->country_id)->get();
         
            $data['city_data'] = City::where('stateid', $request->city_id)->get();
            $data['postcode_data'] = Shipping::where('post_code', $request->post_code)->get();

           



            $data['result'] = Shipping::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.shipping.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


   
   


    /**
     * Store a newly created resource in Subcategory.
     *
     * @param  \App\Http\Requests\StoreSubcategoryRequest  $request
     * @return \Illuminate\Http\Response
    **/
public function store(Request $request)
{
    $country_selection = $request->input('country_selection');
    $country_id = $request->input('country_id');
    $newcountryname = $request->input('newcountryname');
    $state_selection = $request->input('state_selection');
    $state_id = $request->input('state_id');
    $new_state_name = $request->input('new_state_name');
    $city_selection = $request->input('city_selection');
    $city_id = $request->input('city_id');
    $new_city_name = $request->input('new_city_name');
    $postcode = $request->input('postcode');

   
    $country_id = null;
    $state_id = null;
    $city_id = null;

    
    if ($country_selection == 'new') {
        // Check if the country already exists to avoid duplication
        $country = Country::where('name', $newcountryname)->first();

    //      Session::flash('error', ' Country name already exist!');
    // return redirect('admin/shipping')->with('error', 'Country Name already exist.');

        // If the country doesn't exist, create a new entry
        if (!$country) {
            $country = Country::create(['name' => $newcountryname]);
        }
        $country_id = $country->id;
    } else if ($country_selection == 'existing') {
        // Use existing country ID
        $country_id = $request->input('country_id'); // Ensure this is coming from the request
    }

    // Handle state selection
    if ($state_selection == 'new') {
       
        if ($country_id) {
            $state = State::create(['name' => $new_state_name, 'countryid' => $country_id]);
            $state_id = $state->id;
        }
    } else if ($state_selection == 'existing') {
        // Use existing state ID
        $state_id = $request->input('state_id'); // Ensure this is coming from the request
    }

    // Handle city selection
    if ($city_selection == 'new') {
        // Insert new city only if state_id is available
        if ($state_id) {
            $city = City::create(['name' => $new_city_name, 'countryid' => $country_id, 'stateid' => $state_id]);
            $city_id = $city->id;
        }
    } else if ($city_selection == 'existing') {
        // Use existing city ID
        $city_id = $request->input('city_id'); // Ensure this is coming from the request
    }

    // Now insert into Shipping modal using determined IDs
    if ($country_id && $state_id && $city_id) {
        Shipping::create([
            'country_id' => $country_id,
            'state_id' => $state_id,
            'city_id' => $city_id,
            'post_code' => $postcode
        ]);
    }

     // Flash success message and redirect
    Session::flash('success', 'Shipping created successfully!');
    return redirect('admin/location')->with('success', 'Shipping created successfully.');
}


    public function update(Request $request)
    {
      $id = $request->input('id');

    
       $shipping = Shipping::find($id);

      $shipping->update($request->all());

      // Flash success message and redirect
    Session::flash('success', 'Shipping updated successfully!');
    return redirect('admin/location')->with('success', 'Shipping updated successfully.');
        
    }

    /**
     * Remove the specified Subcategory from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function destroy($id)
    {
        try{
            $deleted = Shipping::deleteRecord($id);
            
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
    /**
     * Remove the specified Subcategory from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/




     public function fatchsubcategorydata(Request $request)
{
    $SubcategoryName = Subcategory::where('id', $request->categoryid)->pluck('name')->first();
    $productCount = Product::where('subcategories_id', $request->categoryid)->count();
    

    return response()->json([
        'product_count' => $productCount,
        'SubcategoryName'=>$SubcategoryName
    ]);
}

    public function deletesubcategory(Request $request)
{
    
    Product::where('subcategories_id', $request->categoryIdToDelete)
        ->update(['subcategories_id' => $request->categoryid]);

    

    
    Subcategory::where('id', $request->categoryIdToDelete)->update(['deleted_at' => now()]);


    return response()->json([
        'success' => true,
        'message' => 'Subcategory deleted successfully.'
    ]);
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

public function citychange(Request $request)
{
    $city_id = $request->input('city_id');

    // Fetch zipcodes based on city ID (assuming the 'zipcode' field exists in the Shipping model)
    $zipcodes = Shipping::where('city_id', $city_id)->pluck('post_code');

    // Return the zipcodes as an array in the response
    return response()->json([
        'success' => true,
        'zipcodes' => $zipcodes
    ]);
}



     public function countrychangefilters(Request $request)
{
    
    $country_id= $request->input('country_id');



  $statename = State::where('countryid', $country_id)->get();

    

   

    // Return a response if needed
    return response()->json([
        'success' => true,
        'statename' => $statename
    ]);
}



public function statechangecountrychangefilters(Request $request)
{
    $stateId = $request->input('state_id');

    // Fetch cities based on state ID
    $cities = City::where('stateid', $stateId)->get();

    return response()->json([
        'success' => true,
        'cities' => $cities
    ]);
}

public function postcodefilters(Request $request)
{
    $cityId = $request->input('city_id');



    // Fetch cities based on state ID
    $post_codes = Shipping::where('city_id', $cityId)->get();



    return response()->json([
        'success' => true,
        'post_codes' => $post_codes
    ]);
}





public function shippingrate(Request $request)
    {

       
        try{
            $data['result'] = Shippingrate_type::get();
           $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.shippingrates.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }



  public function updateColumn($id)
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
        
       
         $userId = auth()->user()->id;
         
         $localshippingRate = ShippingRate::where('user_id', $userId)
        ->where('location_type', 'local')->where('type', 'per-order')
        ->first();

        $regionalshippingRate = ShippingRate::where('user_id', $userId)
        ->where('location_type', 'regional')->where('type', 'per-order')
        ->first();
         $otherregionalshippingRate = ShippingRate::where('user_id', $userId)
        ->where('location_type', 'regional-other')->where('type', 'per-order')
        ->first();
        
         $nationalshippingRate = ShippingRate::where('user_id', $userId)
        ->where('location_type', 'national')->where('type', 'per-order')
        ->first();

         $featchcityid = Setting::where('key', 'city')->first()->value;
        $featchcityname = City::where('id', $featchcityid)->first();

        $featchstateid = Setting::where('key', 'state')->first()->value;
        $featchstatename = State::where('id', $featchstateid)->first();
        $citydata = City::where('id', '!=', $featchstateid)->get();
        $staedata = State::where('id', '!=', $featchstateid)->get();
        $countryid = Setting::where('key', 'country')->first()->value;
        $countryname = Country::where('id', $countryid)->first();
          $selectedcity = DB::table('cityenables')
    ->join('cities', 'cityenables.cityid', '=', 'cities.id')
    ->select('cityenables.*', 'cities.name as name') // Select the columns you need
    ->get();

        // this is for north wise state featch

        $northstaedata = State::where('id', '!=', $featchstateid)->where('zone','North')->get();
        $southstaedata = State::where('id', '!=', $featchstateid)->where('zone','south')->get();
        $eaststaedata = State::where('id', '!=', $featchstateid)->where('zone','east')->get();
        $weststaedata = State::where('id', '!=', $featchstateid)->where('zone','west')->get();



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



            return view('admin.shippingrates.shippingrate',compact('localshippingRate','regionalshippingRate','nationalshippingRate','featchcityname','featchstatename','citydata','countryname','otherregionalshippingRate','staedata','northstaedata','southstaedata','eaststaedata','weststaedata','selectedcity','citiesdata','nationalshipping'));
    
        
    }

public function shippingrateupdate(Request $request)
{
  
    
    $userId = auth()->user()->id; 

    // Check if the shipping rate record exists for the user
    $shippingRate = ShippingRate::where('id', $request->shippingrateid)->first();

    if ($shippingRate) {
        // If the record exists, update it
        $shippingRate->rate = $request->shippingFee;
        $shippingRate->transittime = $request->transitTime;
        $shippingRate->type = $request->ratemode;
        $shippingRate->location_type = $request->rateType;
        $shippingRate->freeshipping = $request->freeshipping;
      
         $shippingRate->user_id = $userId;
        $shippingRate->save();

        return response()->json(['message' => 'Shipping rate updated successfully!']);
    } else {
        
        // If the record does not exist, create a new one
        ShippingRate::create([
            'user_id' => $userId,
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
           $userId = auth()->user()->id; 
           
     $featchcityid = Setting::where('key', 'city')->first()->value;
      $featchcityname = City::where('id', $featchcityid)->first();
       $featchstateid = Setting::where('key', 'state')->first()->value;
        $featchstatename = State::where('id', $featchstateid)->first();
         $staedata = State::where('id', '!=', $featchstateid)->get();

         
         $countryid = Setting::where('key', 'country')->first()->value;
          $countryname = Country::where('id', '!=', $countryid)->get();
      
        $localshippingRate = ShippingRate::where('user_id', $userId)
        ->where('location_type', 'local')->where('type', 'per-order')
        ->first();
        
      

       
         $regionalshippingRate = ShippingRate::where('user_id', $userId)
        ->where('location_type', 'regional')->where('type', 'per-order')
        ->first();
         $otherregionalshippingRate = ShippingRate::where('user_id', $userId)
        ->where('location_type', 'regional-other')->where('type', 'per-order')
        ->first();
         $nationalshippingRate = ShippingRate::where('user_id', $userId)
        ->where('location_type', 'national')->where('type', 'per-order')
        ->first();
    
         $cities = DB::table('cities')
        ->leftJoin('shippingrate', function($join) use ($userId) {
            $join->on('cities.id', '=', 'shippingrate.cityid')
                ->where('shippingrate.user_id', '=', $userId);
        })
        ->select('cities.id as city_id', 'cities.name as name', 'shippingrate.id as city_enable_id','shippingrate.transittime as transittime','shippingrate.rate as rate')
        ->where('cities.id', '!=', $featchcityid) // Exclude the single city ID
        ->get();



        $allCities = DB::table('cities')->pluck('id')->toArray();

    // Step 2: Get existing city IDs from shippingrate
    $existingCityIds = DB::table('shippingrate')
         ->where('user_id',$userId )
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
        ->where('user_id',$userId )
    ->where('location_type', 'national') // Condition for national shipping rates
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
   

   
    return view('admin.shippingrates.editshippingrate',compact('cities','featchcityname','featchstatename','regionalshippingRate','otherregionalshippingRate','localshippingRate','countryname','staedata','nationalshippingRate','selectedCities','citiesdata','nationalshipping','selectedStates'));
    
        
    }




public function addnewcity(Request $request)
{
    // Get the array of city IDs
    $cityIds = $request->input('cityIds');


    // Get the authenticated user's ID
    $userId = auth()->user()->id;

    if (!empty($cityIds)) {
        // Convert the city IDs array into a comma-separated string
        $cityIdsString = implode(',', $cityIds);

        // Insert the data into the 'cityenables' table
        DB::table('shippingrate')->insert([
            'user_id' => $userId,
            'cityid' => $cityIdsString,
            'stateid'=>$request->stateid
        ]);
    }

    // Optionally, return a response or redirect
    return redirect()->back();
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
    $userId = auth()->user()->id;

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
    return redirect()->back();
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
        return redirect()->back();
    }

    // Optionally, handle the case where the shipping rate does not exist
    return redirect()->back()->with('error', 'Shipping State not found.');
}

public function editlocation($id)
{  
    $result = Shipping::where('id', $id)->first();
    $country_data = Country::get();
    $state_data = State::where('countryid', $result->country_id)->get();
    $city_data = City::where('stateid', $result->state_id)->get();

    return view('admin.shipping.editlocation', compact('result', 'country_data', 'state_data', 'city_data'));
}



  public function updatelocationColumn($id)
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


}
