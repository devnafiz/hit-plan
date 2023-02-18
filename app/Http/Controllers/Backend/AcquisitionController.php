<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Acquisition;
use App\Models\Backend\ledger;
use App\Models\Backend\plot;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class AcquisitionController extends Controller
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
        $acquisition_data = $this->acquisitionValidation();
        if ($acquisition_data->fails()) {
            return response(['errors' => $acquisition_data->errors()]);
        }
        $acquisition_data = request()->all();
        unset($acquisition_data['_token']);
        $data = Acquisition::insert($acquisition_data["addMoreInputFields"]);
        return response($data);
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
        $acquisition_data = $this->acquisitionValidation();
        if ($acquisition_data->fails()) {
            return redirect()->back()->withFlashWarning("Something went wrong");
        }
        foreach ($request->addMoreInputFields as $data) {
            if (!empty($data['id'])) {
                $data['ledger_id'] = $request->ledger_id;
                $aid = $data['id'];
                unset($data['id']);
                Acquisition::where('id', $aid)->update($data);
            } else {
                $data['ledger_id'] = $request->ledger_id;
                Acquisition::create($data);
            }
        }
        return redirect()->back()->withFlashSuccess("Acquisition's data update successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Acquisition::findOrFail($id)->delete()) {
            return response(["msg" => "Acquisition deleted successfully", 'icon' => "success"]);
        } else {
            return response(["msg" => "it can't be deleted", 'icon' => "warning"]);
        }
    }

    public function acquisitionValidation()
    {
        $data = Validator::make(request()->all(), [
            'addMoreInputFields.*.ledger_id' => 'nullable',
            'addMoreInputFields.*.section_id' => 'required|numeric',
            'addMoreInputFields.*.acq_case' => 'required|string',
            'addMoreInputFields.*.acq_case_date' => 'nullable|string',
            'addMoreInputFields.*.gadget' => 'required|string',
            'addMoreInputFields.*.page_no' => 'required|numeric',
            'addMoreInputFields.*.gadget_date' => 'required|string',
        ]);

        return $data;
    }
}
