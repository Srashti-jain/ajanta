<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
   

    public function index(Request $request)
    {   

        abort_if(!auth()->user()->can('roles.view'),403,__('User does not have the right permissions.'));

        $roles = DB::table('roles')->select('roles.id', 'roles.name');

        if ($request->ajax())
        {
            return DataTables::of($roles)

            ->addIndexColumn()
            ->addColumn('name', function ($row)
            {
                return $row->name;
            })
            ->editColumn('action', 'roles.action')
            ->rawColumns(['name', 'action'])
            ->make(true);
        }

        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        abort_if(!auth()->user()->can('roles.create'),403,__('User does not have the right permissions.'));
        

        $role_permission = Permission::select('name','id')->groupBy('name')->get();

        $custom_permission = array();

        foreach($role_permission as $per){

            $key = substr($per->name, 0, strpos($per->name, ".")); 

            if(str_starts_with($per->name, $key)){
                $custom_permission[$key][] = $per;
            }
            
        }
        

        return view('roles.create',compact('custom_permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        abort_if(!auth()->user()->can('roles.create'),403,__('User does not have the right permissions.'));
        

        $request->validate([
            'name' => 'required|unique:roles,name'
        ],
        [
            'name.required' => __('Role name is required !'),
            'name.unique'   => __('Role name already taken !')
        ]
        );

        $role = Role::create(['name' => $request->name]);

        if($request->permissions){
            foreach ($request->permissions as $key => $value) {
                $role->givePermissionTo($value);
            }
        }
        
        notify()->success(__('Role has been created !'));
        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        
        abort_if(!auth()->user()->can('roles.edit'),403,__('User does not have the right permissions.'));

        if(in_array($id,['1','2','3','4','5'])){
            notify()->error(__('System role cannot be edit !'));
            return redirect(route('roles.index'));
        }
        

        $role = Role::with('permissions')->find($id);

        $role_permission = Permission::select('name','id')->get();

        $custom_permission = array();

        foreach($role_permission as $per){

            $key = substr($per->name, 0, strpos($per->name, ".")); 

            if(str_starts_with($per->name, $key)){
                $custom_permission[$key][] = $per;
            }
            
        }
       
         return view('roles.edit',compact('role_permission','role','custom_permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        
        abort_if(!auth()->user()->can('roles.edit'),403,__('User does not have the right permissions.'));
        
        if(in_array($id,['1','2','3','4','5'])){
            notify()->error('System role cannot be edit !');
            return redirect(route('roles.index'));
        }

        $role = Role::find($id);

        $request->validate([
            'name' => 'required|unique:roles,name,'.$id
        ],
        [
            'name.required' => __('Role name is required !'),
            'name.unique'   => __('Role name already taken !')
        ]
        );

        $role->name = $request->name;

        $role->save();

        $role->syncPermissions($request->permissions);

        notify()->success(__('Role has been updated !'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        abort_if(!auth()->user()->can('roles.delete'),403,__('User does not have the right permissions.'));
        

        $role = Role::find($id);



        if(isset($role)){
            $role->permissions()->detach();
            $role->delete();
            notify()->success(__('Role has been deleted !'),__('DELETED'));
            return back();
        }else{
            notify()->error(__('404 | Role not found !'));
            return back();
        }
    }

    public function createPermission(Request $request){

        Permission::create([
            'name' => $request->name,
        ]);
    
        echo __("Created");
    
        return back();
    }

    public function bulkPermission(Request $request){

        Permission::create([
            'name' => $request->name.'.view',
        ]);

        Permission::create([
            'name' => $request->name.'.create',
        ]);

        Permission::create([
            'name' => $request->name.'.edit',
        ]);

        Permission::create([
            'name' => $request->name.'.delete',
        ]);

        echo __("Created");
    
        return back();

    }
}
