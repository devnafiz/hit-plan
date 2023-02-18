<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\Designation;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['designations'] =DB::table('designation')->paginate(10);
        return view('backend.content.designation.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.content.designation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $info_data = $this->InfoValidation();
         $info_data['status'] ='1';
        $designation = DB::table('designation')->insertGetId($info_data);
        if($designation){
          
        return redirect()
            ->back()
            ->withFlashSuccess('নতুন পদবী সফলভাবে যুক্ত করা হয়েছে');

          }else{
                  return redirect()
            ->back()
            ->withFlashDanger('নতুন পদবী  যুক্ত হয়নি');

          }  

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
        $data['edit_data'] =Designation::where('id',$id)->first();
        
        return view('backend.content.designation.edit',$data);
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
        $info_data = $this->InfoValidation();

        if($request->status==Null){
           $info_data['status']='0'; 
        }else{
            $info_data['status']='1';
        }
        //$info_data['status']=$request->status;
        
       

        
        $designation_info= Designation::where('id',$id)->first();
        //dd($designation_info);
        $designation_info->update($info_data);
         return redirect()
            ->back()
            ->withFlashSuccess('পদবী সফলভাবে আপডেট করা হয়েছে');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $desinfo = Designation::find($id);
        if (!$desinfo) {
            return response(["msg" => "Invalid Delete Request!", 'icon' => "error"]);
        }

        Designation::destroy($desinfo->id);
        return response(["msg" => "পদবী তথ্য সফলভাবে মুছে ফেলা হয়েছে", 'icon' => "success"]);
    }


    public function InfoValidation(){


        $info_data = request()->validate([
            
            'name' => 'required|string',
            'details' => 'required|string',
            
            
        ]);

        return $info_data;
    }
}
