<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\plot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlotController extends Controller
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
        $plot_data = $this->plotValidation($request);
        if ($plot_data->fails()) {
            return response(['errors' => $plot_data->errors()]);
        }

        $plot_data = request()->all();
        unset($plot_data['_token']);
        $data = plot::insert($plot_data["addMoreInputFields"]);
        return response($request->addMoreInputFields[0]['ledger_id']);
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
        $plot = $this->plotValidation();
        if ($plot->fails() == true) {
            return redirect()->back()->withFlashWarning("Something went wrong !");
        }

        foreach ($request->addMoreInputFields as $data) {
            $plot_id = $data['plot_id'] ?? null;
            if (empty($data['ledger_id'])) {
                // $data['ledger_id'] = $request->ledger_id;
                unset($data['plot_id']);
                plot::where('plot_id', $plot_id)->update($data);
            } else {
                unset($data['plot_id']);
                $data['ledger_id'] = $request->ledger_id;
                plot::insert($data);
            }
        }
        return redirect()->back()->withFlashSuccess("Plot's data Update successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plot = Plot::where("plot_id", $id)->delete();
        // $plot->delete();
        if ($plot) {
            return response(["msg" => "PLot deleted successfully", 'icon' => "success"]);
        } else {
            return response(["msg" => "it's can't be deleted", 'icon' => "warning"]);
        }
    }

    public function plotValidation()
    {
        $data = Validator::make(request()->all(), [
            'addMoreInputFields.*.ledger_id' => 'nullable',
            'addMoreInputFields.*.plot_number' => 'required|string',
            'addMoreInputFields.*.land_type' => 'required|numeric',
            'addMoreInputFields.*.land_amount' => 'required',
            'addMoreInputFields.*.land_comments' => 'nullable|string',
        ]);

        return $data;
    }
}
