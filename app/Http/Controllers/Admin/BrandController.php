<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Language;

use Session;

class BrandController extends Controller
{
    /**
     * Display a listing of the categories.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
    public function index(Request $request)
    {
        
        try{
            $data['result'] = Brand::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.Brand.list',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


    /**
     * Display a listing of the categories.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
 


    /**
     * Store a newly created resource in category.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
    **/

    public function store(Request $request)
    {
          
        try{
            $added = Brand::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/brand')->with('success', $added['message']); 
            }
            else{
                return redirect()->back()->with('error', $added['message']);
            }
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


    /**
     * Display a edit listing of the categories.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
    public function edit(Request $request,$id)
    {
        try{
            $data = Brand::where('id',$id)->first();
            return view('admin.category.edit',compact('data'));
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function update(Request $request)
    {
        try{
            $updated = Brand::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/brand')->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function destroy($id)
    {
        try{
            $deleted = Brand::deleteRecord($id);
            
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
     * Update the specified category from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function updateColumn($id)
    {
        try{
            $updated = Brand::updateColumn($id);
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


     /**
     * Update the specified category from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function updateIsFeaturedColumn($id)
    {
        try{
            $updated = Category::updateFeaturedColumn($id);
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
    
    
    
 
    
     public function translation($id)
    {
        $brand = Brand::find($id);
        $languages = Language::where('status',1)->get();

        foreach ($languages as $language) {
           // dd($language);
            $language->details = BrandTranslation::where('brand_id',$id)->where('language_code',$language->code)->first();

            if (!$language->details) {
                $brandData = [
                   'brand_id' => $id,
                    'language_code' => $language->code,
                    'name' => $brand->name,
                    'created_at' => date("Y-m-d H:i:s")
                ];
                BrandTranslation::create($brandData);
                $language->details = BrandTranslation::where('brand_id', $id)
                    ->where('language_code', $language->code)
                    ->first();
            }
        }
        return view('admin.Brand.translation', compact('brand', 'languages'));
    }
    
    
    public function updateTranslation($id, Request $request)
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

            $BrandTranslation = [
                'language_code' => $input['language_code'][$i],
                'name' => $input['name'][$i],
                'updated_at' => now(),
            ];
            if ($translationId) {
                BrandTranslation::where('id', $translationId)->update($BrandTranslation);
            } else {
                $BrandTranslation['brand_id'] = $id;
                BrandTranslation::create($BrandTranslation);
            }
        }
        Session::flash('success', 'Translation updated successfully!');
        return redirect(url('admin/brand'))->with('success', 'Translation updated successfully.');

    }
    
    
    
    
    
    
    
    
    
    
    
    

}
