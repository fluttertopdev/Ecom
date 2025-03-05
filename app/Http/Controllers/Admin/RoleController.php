<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the live news.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        try {
            $data['result'] = Role::getLists($request->all());
            $data['permission'] = Permission::select('group', DB::raw('group_concat(id) as ids'))
                ->groupBy('group')
                ->get();

            foreach ($data['permission'] as $row) {
                $row->permission = Permission::whereIn('id', explode(',', $row->ids))->get();
            }

            return view('admin/role/index',$data);            
        } 
        catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage(). '. $ex->getLine(). '. $ex->getFile());
        }
    }

    /**
     * Store a newly created live news in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
 public function store(StoreRoleRequest $request)
{
    try {
        // Server-side validation for role name
        $validated = $request->validated();

        // Check if the role name is present and not empty
        if (empty($request->name)) {
            return redirect()->back()->with('error', 'Role name is required.')->withInput();
        }

        // If all validations pass, proceed with adding/updating the role
        $added = Role::addUpdate($request->all());

        if ($added['status']) {
            return redirect('admin/role')->with('success', $added['message']);
        } else {
            return redirect()->back()->with('error', $added['message']);
        }
    } catch (\Exception $ex) {
        return redirect()->back()->with('error', $ex->getMessage() . ' ' . $ex->getLine() . ' ' . $ex->getFile());
    }
}


    /**
     * Update the specified live news in storage.
     *
     * @param  \App\Http\Requests\UpdateLiveNewsRequest  $request
     * @param  \App\Models\LiveNews  $liveNews
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request)
    {
        try{
            $validated = $request->validated();
             if (empty($request->name)) {
            return redirect()->back()->with('error', 'Role name is required.')->withInput();
        }
            $updated = Role::addUpdate($request->all(),$request->input('id'));
            if($updated['status']){
                return redirect('admin/role')->with('success', $updated['message']); 
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
     * Remove the specified live news from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $deleted = Role::deleteRecord($id);
            if($deleted['status']){
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
     * Remove the specified category from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function changeStatus($id,$status)
    {
        try{
            $updated = Role::changeStatus($status,$id);
            if($updated['status']){
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
