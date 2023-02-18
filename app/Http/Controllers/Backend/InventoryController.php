<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\InventoryDetails;
use App\Models\Backend\InventoryType;
use App\Models\Backend\Division;

class InventoryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        return view('backend.content.inventory.index');
    }


    public function create()
    {
        $data['inventory'] = InventoryType::get(['type', 'file_id']);
        return view('backend.content.inventory.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inventory_data = $this->caseInfoValidation();

        $inventoryupload = InventoryDetails::insert($inventory_data);

        if ($inventoryupload) {
            return redirect()->back()->withFlashSuccess("ইনভেনটরীর তথ্য সফলভাবে যুক্ত করা হয়েছে");
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
        //
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
        //
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

    public function caseInfoValidation()
    {
        $inventory_data = request()->validate([
            'file_no' => 'required|numeric',
            'file_type' => 'required|numeric',
            'self' => 'required|numeric',
            'file_column' => 'required|numeric',
            'row' => 'required|numeric',
        ]);

        return $inventory_data;
    }
}
