<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class SettingController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view("backend.content.settings.index");
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
    $request->validate([
      'app_name' => 'nullable|string',
      'app_name_short' => 'nullable|string',
      'app_email' => 'nullable|string',
      'app_url' => 'nullable|string',
      'app_logo' => 'nullable',
      'fabicon' => 'nullable',
      'footer_text' => 'nullable|string',
      'company_address' => 'nullable|string',
      'company_details' => 'nullable|string',
    ]);

    $data = [];
    if ($request->app_name) {
      $data['app_name'] = $request->app_name;
    }
    if ($request->app_name_short) {
      $data['app_name_short'] = $request->app_name_short;
    }
    if ($request->app_email) {
      $data['app_email'] = $request->app_email;
    }
    if ($request->app_url) {
      $data['app_url'] = $request->app_url;
    }
    if ($request->footer_text) {
      $data['footer_text'] = $request->footer_text;
    }
    if ($request->company_address) {
      $data['company_address'] = $request->company_address;
    }
    if ($request->company_details) {
      $data['company_details'] = $request->company_details;
    }

    if ($request->app_logo  && $request->app_logo != "undefined") {
      $app_logo = 'logo' . '.' . $request->app_logo->getClientOriginalExtension();
      $request->app_logo->move(public_path('img/logo/'), $app_logo);
      $data['app_logo'] = $app_logo;
    }

    if ($request->fabicon && $request->fabicon != "undefined") {
      $fabicon = 'fab' . '.' . $request->fabicon->getClientOriginalExtension();
      $request->fabicon->move(public_path('img/logo/'), $fabicon);
      $data['fabicon'] = $fabicon;
    }

    Setting::save_settings($data);
    Cache::forget('settings');
    return response()->json(['success' => "Settings saved successfully"]);
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
    Setting::destroy($id);
    return redirect()->back()->withFlashSuccess("Setting deleted successfully");
  }
}
