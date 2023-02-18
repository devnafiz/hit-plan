<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Acquisition;
use App\Models\Backend\Division;
use App\Models\Backend\Kachari;
use App\Models\Backend\District;
use App\Models\Backend\LandType;
use App\Models\Backend\ledger;
use App\Models\Backend\Mouja;
use App\Models\Backend\plot;
use App\Models\Backend\Record;
use App\Models\Backend\Section;
use App\Models\Backend\Station;
use App\Models\Backend\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgricultureBalamController extends Controller
{


    public function create()
    {
        $data['division'] = Division::get(["division_name", "division_id"]);
        $data1['record'] = Record::get(["id", "record_name"]);
        $data2['section'] = Section::get(["section_id", "section_name"]);
        $data['land_type'] = LandType::get(["land_type_id", "land_type"]);
        return view('backend.content.agriculture.balam', $data, $data1)->with($data2);
    }
}
