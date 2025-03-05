<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Language;
use App\Models\SubCategoryTranslation;

use Session;



class SubcategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
    public function index(Request $request)
    {
        try{
            $data['category_data'] = Category::get();
            $data['result'] = Subcategory::getLists($request->all());
            $data['statusTypes'] = \Helpers::getStatusType();
            return view('admin.subcategory.list',$data);
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
    public function create(Request $request)
    { 
        return view('admin.subcategory.create');
    }


    /**
     * Store a newly created resource in Subcategory.
     *
     * @param  \App\Http\Requests\StoreSubcategoryRequest  $request
     * @return \Illuminate\Http\Response
    **/

    public function store(Request $request)
    {

        try{
            $added = Subcategory::addUpdate($request->all());
            if($added['status']==true){
                Session::flash('success', $added['message']);
                return redirect('admin/subcategory')->with('success', $added['message']); 
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
            $data = Subcategory::where('id',$id)->first();
            return view('admin.subcategory.edit',compact('data'));
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Update the specified Subcategory in storage.
     *
     * @param  \App\Http\Requests\UpdateSubcategoryRequest  $request
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function update(Request $request)
    {
        try{
            $updated = Subcategory::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/subcategory')->with('success', $updated['message']); 
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
     * Remove the specified Subcategory from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function destroy($id)
    {
        try{
            $deleted = Subcategory::deleteRecord($id);
            
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
    public function updateColumn($id)
    {
        try{
            $updated = Subcategory::updateColumn($id);
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

      public function updatepopular($id)
    {

         
        try{
            $updated = Subcategory::updatepopular($id);
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

  public function translation($id)
    {
        $subcategory = Subcategory::find($id);
        $languages = Language::where('status',1)->get();

        foreach ($languages as $language) {
           // dd($language);
            $language->details = SubCategoryTranslation::where('subcategory_id',$id)->where('language_code',$language->code)->first();

            if (!$language->details) {
                $subcategoryData = [
                   'subcategory_id' => $id,
                    'language_code' => $language->code,
                    'name' => $subcategory->name,
                    'created_at' => date("Y-m-d H:i:s")
                ];
                SubCategoryTranslation::create($subcategoryData);
                $language->details = SubCategoryTranslation::where('subcategory_id', $id)
                    ->where('language_code', $language->code)
                    ->first();
            }
        }
        return view('admin.subcategory.translation', compact('subcategory', 'languages'));
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

            $categoryTranslationData = [
                'language_code' => $input['language_code'][$i],
                'name' => $input['name'][$i],
                'updated_at' => now(),
            ];
            if ($translationId) {
                SubCategoryTranslation::where('id', $translationId)->update($categoryTranslationData);
            } else {
                $categoryTranslationData['subcategory_id'] = $id;
                SubCategoryTranslation::create($categoryTranslationData);
            }
        }
        Session::flash('success', 'Translation updated successfully!');
        return redirect(url('admin/subcategory'))->with('success', 'Translation updated successfully.');

    }




















}
