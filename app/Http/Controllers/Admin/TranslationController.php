<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Translation;
use App\Models\Language;
use App\Http\Requests\Translation\StoreTranslationRequest;
use App\Http\Requests\Translation\UpdateTranslationRequest;

class TranslationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index(Request $request, $language_id = null)
{
    try {
        // Add language_id to filters if provided
        $filters = $request->all();
        if ($language_id) {
            $filters['language_id'] = $language_id;
        }

        // Retrieve translations with filters
        $data['result'] = Translation::getLists($filters);

        // Fetch all available languages for dropdown or filters
        $data['languages'] = Language::where('status', 1)->get();

        // Pass selected language_id back to view
        $data['selected_language'] = $language_id;
        
      
        
    

        return view('admin.translation.index', $data);
    } catch (\Exception $ex) {
        return redirect()->back()->with('error', $ex->getMessage() . ' ' . $ex->getLine() . ' ' . $ex->getFile());
    }
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTranslationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
          
        try{
            
            $added = Translation::addUpdate($request->all());
            if($added['status']){
            return redirect('admin/translation/' . $request->transid)->with('success', $added['message']);
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $data['row'] = Translation::getDetail($id);
            return view('admin/translation.edit',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTranslationRequest  $request
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    { 
       
        try{
           
            $updated = Translation::addUpdate($request->all(),$request->input('id'));
            if($updated['status']){
               return response()->json(['success' => true, 'message' => 'Translation updated successfully.']); 
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
