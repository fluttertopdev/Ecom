<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Homepage;
use App\Models\Visibilitie;
use App\Models\Cms;
use App\Models\Language;
use App\Models\CmsTranslation;
use App\Models\HomepageTranslation;

use DB;
use Session;



class BannerController extends Controller
{
    
    
  
    public function index(Request $request)
    {

         
        try{
            
            $data['result'] = Banner::getLists($request->all());
            $data['bannerresult'] = Banner::midsizedgetLists($request->all());



            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.banner.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    public function Homepageicon(Request $request)
    {  

    $data['iconsresult'] = Banner::homepageicongetlist($request->all());


     return view('admin.banner.homepageicon',$data);
       
    }

public function homepageupdateIcons(Request $request)
{
    // Check if there are any icons in the request
    if ($request->has('icons')) {
        foreach ($request->input('icons') as $id => $data) {
            // Initialize icon path as null
            $iconPath = null;

            // Check if a file is uploaded for this icon
            if (isset($request['icon'][$id]['icon']) && $request['icon'][$id]['icon'] != '') {
                $uploadImage = \Helpers::uploadFiles($request['icon'][$id]['icon'], 'banner/icon');
                if ($uploadImage['status'] === true) {
                    $iconPath = $uploadImage['file_name'];
                }
            }

            // Update the record in the Banner table for the corresponding icon ID
            \DB::table('banners')
                ->where('id', $id)
                ->where('type', 'icon')  // Make sure we are updating the correct type
                ->update([
                    'icon' => $iconPath ?? \DB::raw('icon'), // Retain old icon if no new file is uploaded
                    'textfield1' => $data['textfield1'] ?? null,
                    'textfield2' => $data['textfield2'] ?? null,
                    'updated_at' => now(),
                ]);
        }
    }

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Icons updated successfully!');
}


 public function productcoustomsection(Request $request)
    {  

     $data['result'] = Homepage::getLists($request->all());


          
   $data['statusTypes'] = \Helpers::getStatusType();


     return view('admin.banner.producttag',$data);
       
    }
    public function updatecoustomColumn($id)
    {
        
    
        try{
            $updated = Homepage::updateColumn($id);
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

    public function createcoustomsection(Request $request)
    {  

       $categories = Category::where('status', 1)->get();
       $subcategory = Subcategory::where('status', 1)->get();
       $visibilitie = Visibilitie::where('status', 1)->get();


     return view('admin.banner.addcustomsection',compact('categories','subcategory','visibilitie'));
       
    }





       public function storeproducttag(Request $request)
    {

        try{
            $added = Banner::addUpdatetags($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/product-coustom-section')->with('success', $added['message']); 
            }
            else{
                return redirect()->back()->with('error', $added['message']);
            }
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }




    public function store(Request $request)
    {

        try{
            $added = Banner::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/banner')->with('success', $added['message']); 
            }
            else{
                return redirect()->back()->with('error', $added['message']);
            }
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


       public function storecoustomsection(Request $request)
    {

        try{
            $added = Homepage::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/product-coustom-section')->with('success', $added['message']); 
            }
            else{
                return redirect()->back()->with('error', $added['message']);
            }
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

     public function editcoustomsection($id)
    {  

       $result = Homepage::where('id', $id)->first();
        $categories = Category::where('status', 1)->get();
       $subcategory = Subcategory::where('status', 1)->get();
       $visibilitie = Visibilitie::where('status', 1)->get();


     return view('admin.banner.editcoustomsection',compact('result','categories','subcategory','visibilitie'));
       
    }



  public function updatecoustomsection(Request $request)
    {
        try{
            $updated = Homepage::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/product-coustom-section')->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
   
  

    public function update(Request $request)
    {
        try{
            $updated = Banner::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/banner')->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

  

      public function coustomsectiondestroy($id)
    {

        
        try{
            $deleted = Homepage::deleteRecord($id);
            
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
     public function destroy($id)
    {
         
        try{
            $deleted = Banner::deleteRecord($id);
            
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



  
    public function updateColumn($id)
    {
        try{
            $updated = Banner::updateColumn($id);
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


       public function shhhtorecoustomsection(Request $request)
{
    // Retrieve input data from the request
    $data = $request->all();

    // Process single banner image
    if (isset($data['single_bannerimg']) && $data['single_bannerimg'] != '') {
        $uploadImage = \Helpers::uploadFiles($data['single_bannerimg'], 'banner/website_banner');
        if ($uploadImage['status'] == true) {
            $data['single_bannerimg'] = $uploadImage['file_name'];
        }
    }

    // Process combo banner image 1
    if (isset($data['combo_bannerimg1']) && $data['combo_bannerimg1'] != '') {
        $uploadImage = \Helpers::uploadFiles($data['combo_bannerimg1'], 'banner/website_banner');
        if ($uploadImage['status'] == true) {
            $data['combo_bannerimg1'] = $uploadImage['file_name'];
        }
    }

    // Process combo banner image 2
    if (isset($data['combo_bannerimg2']) && $data['combo_bannerimg2'] != '') {
        $uploadImage = \Helpers::uploadFiles($data['combo_bannerimg2'], 'banner/website_banner');
        if ($uploadImage['status'] == true) {
            $data['combo_bannerimg2'] = $uploadImage['file_name'];
        }
    }

    // Save data to Homepage model
    $homepage = new Homepage();
    $homepage->section_type = $data['section_type'] ?? null;
    $homepage->banner_type = $data['banner_type'] ?? null;
    $homepage->tag_name = $data['tag_name'] ?? null;
    $homepage->single_bannerimg = $data['single_bannerimg'] ?? null;
    $homepage->singlebanner_url = $data['singlebanner_url'] ?? null;
    $homepage->combo_bannerimg1 = $data['combo_bannerimg1'] ?? null;
    $homepage->combobanner_url1 = $data['combobanner_url1'] ?? null;
    $homepage->combo_bannerimg2 = $data['combo_bannerimg2'] ?? null;
    $homepage->combobanner_url2 = $data['combobanner_url2'] ?? null;
    $homepage->save();

    return redirect('admin/product-coustom-section')->with('success', 'Added');
}



public function sorting(Request $request)
{
    try {
        foreach ($request->order as $order) {
            Homepage::where('id', $order['id'])->update(['order' => $order['position']]);
        }
        return response()->json([
            'status' => true,
            'message' => __('lang.message_data_retrieved_successfully')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
}
   
     // CMS section start here



 public function cms(Request $request)
    {  

     $data['result'] = Cms::getLists($request->all());


          
   $data['statusTypes'] = \Helpers::getStatusType();


     return view('admin.banner.cms',$data);
       
    }


   public function addcms(Request $request)
    {  

     


     return view('admin.banner.addCms');
       
    }



  

       public function storecms(Request $request)
    {

        try{
            $added = Cms::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/cms')->with('success', $added['message']); 
            }
            else{
                return redirect()->back()->with('error', $added['message']);
            }
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

     public function editcms($slug,$id)
    {  

       $result = Cms::where('id', $id)->first();
   


     return view('admin.banner.editcms',compact('result'));
       
    }


   
    public function updatecms(Request $request)
    {
        try{
            $updated = Cms::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/cms')->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


      public function updatecmscolumn($id)
    {
        try{
            $updated = Cms::updateColumn($id);
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



 
   public function visibilities(Request $request)
    {  

    $data['result'] = Visibilitie::getLists($request->all());


     return view('admin.visibilities.list',$data);
       
    }


   public function storevisibilities(Request $request)
    {

        try{
            $added = Visibilitie::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/visibilities')->with('success', $added['message']); 
            }
            else{
                return redirect()->back()->with('error', $added['message']);
            }
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

  public function updatevisibilities(Request $request)
    {
        try{
            $updated = Visibilitie::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/visibilities')->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


 public function visibilitiesdestroy($id)
    {

        
        try{
            $deleted = Visibilitie::deleteRecord($id);
            
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
    
    
    
    
       public function cmsdestroy($id)
    {
        try{
            $deleted = Cms::deleteRecord($id);
            
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
    
    
     public function translation($id)
    {
        $cms = Cms::find($id);
        $languages = Language::where('status',1)->get();

        foreach ($languages as $language) {
           // dd($language);
            $language->details = CmsTranslation::where('cms_id',$id)->where('language_code',$language->code)->first();

            if (!$language->details) {
                $cmsData = [
                   'cms_id' => $id,
                    'language_code' => $language->code,
                    'title' => $cms->title,
                    'description' => $cms->des,
                    
                    'created_at' => date("Y-m-d H:i:s")
                ];
                CmsTranslation::create($cmsData);
                $language->details = CmsTranslation::where('cms_id', $id)
                    ->where('language_code', $language->code)
                    ->first();
            }
        }
        return view('admin.banner.translation', compact('cms', 'languages'));
    }





  public function updateTranslation($id, Request $request)
    {
      
        $request->validate([
            'language_code' => 'required|array',
            'language_code.*' => 'required|string',
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
            'description' => 'required|array',
          'description.*' => 'required|string',
        ]);

        $input = $request->all();

        for ($i = 0; $i < count($input['language_code']); $i++) {
            $translationId = $input['translation_id'][$i] ?? null;

            $cmsTranslationData = [
                'language_code' => $input['language_code'][$i],
                'title' => $input['title'][$i],
                'description' => $input['description'][$i],
                
                'updated_at' => now(),
            ];
            if ($translationId) {
                CmsTranslation::where('id', $translationId)->update($cmsTranslationData);
            } else {
                $cmsTranslationData['cms_id'] = $id;
                CmsTranslation::create($cmsTranslationData);
            }
        }
        Session::flash('success', 'Translation updated successfully!');
        return redirect(url('admin/cms'))->with('success', 'Translation updated successfully.');

    }
    
    
    
    
       public function coustomsectiontranslation($id)
    {
        $Homepage = Homepage::find($id);
        $languages = Language::where('status',1)->get();

        foreach ($languages as $language) {
           // dd($language);
            $language->details = HomepageTranslation::where('homepage_id',$id)->where('language_code',$language->code)->first();

            if (!$language->details) {
                $homepageData = [
                   'homepage_id' => $id,
                    'language_code' => $language->code,
                    'name' => $Homepage->title,
             
                    
                    'created_at' => date("Y-m-d H:i:s")
                ];
                HomepageTranslation::create($homepageData);
                $language->details = HomepageTranslation::where('homepage_id', $id)
                    ->where('language_code', $language->code)
                    ->first();
            }
        }
        return view('admin.banner.coustomsectiontranslation', compact('Homepage', 'languages'));
    }





  public function updatecoustomsectiontranslate($id, Request $request)
    {
      
        $request->validate([
            'language_code' => 'required|array',
            'language_code.*' => 'required|string',
            'name' => 'required|array',
            'name.*' => 'required|string|max:255',
           
        ]);

        $input = $request->all();

        for ($i = 0; $i < count($input['language_code']); $i++) {
            $translationId = $input['translation_id'][$i] ?? null;

            $homepageTranslationData = [
                'language_code' => $input['language_code'][$i],
                'name' => $input['name'][$i],
         
                
                'updated_at' => now(),
            ];
            if ($translationId) {
                HomepageTranslation::where('id', $translationId)->update($homepageTranslationData);
            } else {
                $homepageTranslationData['homepage_id'] = $id;
                HomepageTranslation::create($homepageTranslationData);
            }
        }
        Session::flash('success', 'Translation updated successfully!');
        return redirect(url('admin/product-coustom-section'))->with('success', 'Translation updated successfully.');

    }  
    
    
    
    
    

}
