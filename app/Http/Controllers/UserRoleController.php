<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    private $roles = "user_roles";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = DB::table($this->roles)
            ->select('*')
            ->get();

        return view('admin.pages.role.show-role')->with('roles',$roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {       

        return view('admin.pages.role.add-role');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate( $request,[
            'roleName' => 'required|max:155',
            'roleDescription' => 'required|max:400',
            'active' => 'numeric|max:1',
        ]); 
        $role = new UserRole;
        $role->role_name = $request->input('roleName');
        $role->role_description = $request->input('roleDescription');
        $role->active_status = $request->input('active');
        $role->save();

        return redirect()->back()->with('success','Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function show(UserRole $userRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = DB::table($this->roles)->where('id', $id)->first();
        return view('admin.pages.role.edit-role')->with('role', $role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate( $request,[
            'roleName' => 'required|max:155',
            'roleDescription' => 'required|max:400',
            'active' => 'numeric|max:1',
        ]); 

        $role = UserRole::find($id);
        $role->role_name = $request->input('roleName');
        $role->role_description = $request->input('roleDescription');
        $role->active_status = $request->input('active');
        $role->save();

        return redirect('roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table($this->roles)->where('id', '=', $id)->delete();
        return redirect()->back();
    }
}