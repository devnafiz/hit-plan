<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\CaseDate;

class CaseDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   
    public function index()
    {
        //
    }

    public  function dateCreate($id){
        $id =$id;
        return view('backend.content.case.includes.case_date',compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $case_date_data = $this->caseDateValidation();

        if($case_date_data){
                    $short_order = $case_date_data['short_order'];
                    //dd($short_order);
                    $case_next_date = $case_date_data['case_next_date']; 

                    $data = [
                       
                        'case_id' => $request->case_id,
                        'short_order' => $short_order,
                        'case_next_date' => $case_next_date,
                    ];
                    CaseDate::create($data);


                }
                return redirect()
                ->back()
                ->withFlashSuccess('মামলার পরবর্তী তারিখ সফলভাবে যুক্ত করা হয়েছে');     
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

         $casedate =CaseDate::findOrFail($id);
         //dd($casedate);
        return view('backend.content.case.includes.edit_case_date',compact('casedate'));
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
        $case_date_data = $this->caseDateValidation();
        if (!empty($id)) {
            CaseDate::where('id', $id)->update($case_date_data);
        }
        return redirect()
        ->back()
        ->withFlashSuccess('মামলার পরবর্তী তারিখ সফলভাবে সংশোধন করা হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function caseDateValidation()
    {
         $case_date_data=request()->validate([
            'short_order' => 'nullable|string',
            'case_next_date' => 'nullable|string',
    
         ]);

         return $case_date_data;


    }
}
