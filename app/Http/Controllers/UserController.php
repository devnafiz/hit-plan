<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller
{

    private $users = "users";
    private $roles = "user_roles";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = DB::table($this->users.' as users')
        //     ->leftJoin($this->roles.' as roles', 'roles.id', '=', 'users.role_id')
        //     ->select('users.id','users.name','users.email','users.nice_name','users.gender','users.picture','users.block_status','users.online_status','users.created_at', 'roles.role_name')
        //     ->orderBy('users.created_at', 'desc')
        //     ->paginate(15);

        $users = User::with(['role'])->orderBy('id', 'desc')->paginate(10);

        return view('admin.pages.user.show-user')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = DB::table($this->roles)
            ->select('id', 'role_name')
            ->get();
        return view('admin.pages.user.add-user')->with('roles', $roles);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'active' => 'numeric|max:1',
            'niceName' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'UserName' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'userRole' => 'required|numeric|max:99',
            'phone' => 'required|regex:/(01)[0-9]{9}/',
            'gender' => 'string|max:155',
            'image' => 'mimes:jpeg,jpg,png,gif|nullable|max:1024',
        ]);


        $user = new User;
        $user->name = $request->UserName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nice_name = $request->niceName;
        $user->gender = $request->gender;
        $user->block_status = $request->active;
        $user->phone = $request->phone;
        $user->role_id = $request->userRole;

        // Insert Image
        $image = $request->file('image');
        $img = time() . '.' . $image->getClientOriginalExtension();
        //$location = public_path('uploads/categories/'.$img);
        $image->move('uploads/users/', $img);
        // Image::make($image)->save($location);
        $user->picture = $img;

        $user->save();

        return redirect()->back()->with('success', 'Added New User Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::with(['role'])->orderBy('id', 'desc')->paginate(10);

        return view('admin.pages.user.show-user')->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = DB::table($this->roles)
            ->select('id', 'role_name')
            ->get();
        $user = DB::table($this->users)->where('id', $id)->first();
        return view('admin.pages.user.edit-user')->with('roles', $roles)->with('user', $user);
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
        $this->validate($request, [
            'active' => 'numeric|max:1',
            'niceName' => 'string|max:255',
            'email' => 'required|string|email|max:255',
            'UserName' => 'required|string|max:255',
            'phone' => 'required|regex:/(01)[0-9]{9}/',
            'userRole' => 'required|numeric|max:99',
            'gender' => 'string|max:155',
            'image' => 'mimes:jpeg,jpg,png,gif|nullable|max:1024',
        ]);

        $user = User::find($id);
        // Handle File Upload
        if ($request->hasFile('image')) {
            if (file_exists('uploads/users/' . $user->picture)) {
                unlink('uploads/users/' . $user->picture);
            }
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            //Input::file('image')->move('uploads/users', $fileNameToStore);
            $request->file('image')->move('uploads/users', $fileNameToStore);
            //$path = $request->file('image')->storeAs('public/users', $fileNameToStore);

            DB::table($this->users)->where('id', $id)->update(
                [
                    'name' => $request->input('UserName'),
                    'email' => $request->input('email'),
                    'nice_name' => $request->input('niceName'),
                    'phone' => $request->input('phone'),
                    'gender' => $request->input('gender'),
                    'picture' => $fileNameToStore,
                    'block_status' => $request->input('active') == 1 ? 1 : 0,
                    'role_id' => $request->input('userRole'),
                    'updated_at' => DB::raw('now()')
                ]
            );
        } else {
            DB::table($this->users)->where('id', $id)->update(
                [
                    'name' => $request->input('UserName'),
                    'email' => $request->input('email'),
                    'nice_name' => $request->input('niceName'),
                    'phone' => $request->input('phone'),
                    'gender' => $request->input('gender'),
                    'block_status' => $request->input('active') == 1 ? 1 : 0,
                    'role_id' => $request->input('userRole'),
                    'updated_at' => DB::raw('now()')
                ]
            );
        }
        return redirect('/users')->with('success', 'User updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // DB::table($this->users)->where('id', '=', $id)->delete();
        $user = User::find($id);
        if (file_exists('uploads/users/' . $user->picture)) {
            unlink('uploads/users/' . $user->picture);
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
