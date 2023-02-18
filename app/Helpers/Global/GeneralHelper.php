<?php

use App\Models\Backend\CommercialMouja;
use App\Models\Backend\Setting;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use App\Models\Backend\Upazila;
use App\Models\Backend\District;
use App\Models\Backend\Kachari;
use App\Models\Backend\Division;
use App\Models\Backend\ledger;
use App\Models\Backend\MasterPlan;
use App\Models\Backend\MasterPlanMouja;
use App\Models\Backend\MasterPlanPlot;
use App\Models\Backend\Station;
use App\Models\Backend\Mouja;
use App\Models\Backend\plot;
use EasyBanglaDate\Types\BnDateTime;

if (!function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name', 'Laravel Boilerplate');
    }
}

if (!function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     *
     * @return Carbon
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (!function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (auth()->check()) {
            if (
                auth()
                ->user()
                ->isAdmin()
            ) {
                return 'admin.dashboard';
            }
            if (
                auth()
                ->user()
                ->isUser()
            ) {
                return 'frontend.index';
            }
        }

        return 'frontend.index';
    }
}

if (!function_exists('general_settings')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function general_settings($json = false)
    {
        $setting = Cache::get('settings', function () {
            return Setting::whereNotNull('active')->get();
        });

        if ($json) {
            return json_encode($setting->pluck('value', 'key')->toArray());
        }

        return $setting;
    }
}

if (!function_exists('get_setting')) {
    /**
     * Helper to grab the application name.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    function get_setting($key, $default = null)
    {
        $setting = general_settings()
            ->where('key', $key)
            ->first();
        return $setting ? $setting->value : $default;
    }
}

if (!function_exists('get_step_value')) {
    function get_step_value($step, $key, $default = null)
    {
        $session = session()->get('member', []);
        if (!empty($session)) {
            $step = key_exists($step, $session) ? $session[$step] : [];
            if (is_array($step)) {
                $default = key_exists($key, $step) ? $step[$key] : '';
            }
        }
        return $default;
    }
}

if (!function_exists('store_picture')) {
    function store_picture($file, $dir_path = '/', $name = null)
    {
        $imageName = $name ? $name : $file->getClientOriginalName();
        // $dir_path = 'storage/' . $dir_path;
        $pathDir = create_public_directory($dir_path); // manage directory
        $img = Image::make($file);
        $fileSize = round($img->filesize() / 1024); // convert to kb

        if ($img->width() > 1080 || $fileSize > 500) {
            $img->resize(1080, null, function ($c) {
                $c->aspectRatio();
            })->save($pathDir . '/' . $imageName, 90); // save converted photo
        } else {
            $img->save($pathDir . '/' . $imageName, 90); // save original photo
        }

        $thumbPathDir = create_public_directory($dir_path . '/thumbs'); // manage thumbs directory
        if ($img->width() > 350 || $fileSize > 150) {
            $img->resize(350, null, function ($c) {
                $c->aspectRatio();
            })->save($thumbPathDir . '/' . $imageName, 90); // save thumbs photo
        } else {
            $img->save($thumbPathDir . '/' . $imageName, 90); // save thumbs photo
        }
        return $imageName;
    }
}

if (!function_exists('create_public_directory')) {
    function create_public_directory($path)
    {
        File::isDirectory(public_path('storage')) ?: Artisan::call('storage:link');
        File::isDirectory(public_path($path)) ?: File::makeDirectory(public_path($path), 0777, true, true);
        return public_path($path);
    }
}

if (!function_exists('status_decode')) {
    function status_decode($status)
    {
        return str_replace('_', ' ', $status);
    }
}

if (!function_exists('generate_number')) {
    function generate_number($id, $length, $user)
    {
        $unique_number = $user . str_pad($id, $length, '0', STR_PAD_LEFT);
        return $unique_number;
    }
}

if (!function_exists('districts')) {
    function districts()
    {
        return District::orderBy('district_name')
            ->pluck('district_name', 'district_id')
            ->prepend('All Districts', '');
    }
}

if (!function_exists('thanas')) {
    function thanas()
    {
        $thanas = Upazila::get()->pluck('upazila_name', 'upazila_id');
        return $thanas;
    }
}

if (!function_exists('land_amount')) {
    function land_amount($value)
    {
        $total = 0;
        foreach ($value as $val) {
            if (!empty($val->land_amount)) {
                $total += $val->land_amount;
            }
        }
        $bn = ledger::en2bn(number_format($total, 2));
        return $bn;
    }
}

if (!function_exists('station_name')) {
    function station_name($value)
    {
        $station_data = json_decode($value);
        $stations = Station::select('station_id', 'station_name')
            ->whereIn('station_id', $station_data)
            ->get();
        return $stations;
    }
}

if (!function_exists('license_moujas')) {
    function license_moujas($value)
    {
        $moujas = null;
        $records = null;
        $plots = null;
        $ledgers = null;
        $property_amount = 0;
        $leased_area = 0;

        foreach ($value as $val) {
            $mouja = Mouja::where('mouja_id', $val->mouja_id)
                ->pluck('mouja_name')
                ->first();
            $moujas .= $mouja . ',';
            if ($val->ledger_id) {
                $ledger = ledger::where('id', $val->ledger_id)
                    ->pluck('ledger_number')
                    ->first();
                $ledgers .= $ledger ? $ledger . ',' : '';
            }

            if ($val->record_name == 1) {
                $records = 'সি.এস' . ',';
            }
            if ($val->record_name == 2) {
                $records = 'এস.এ' . ',';
            }
            if ($val->record_name == 3) {
                $records = 'আর.এস' . ',';
            }

            if ($val->property_amount) {
                $property_amount += $val->property_amount;
            }

            if ($val->leased_area) {
                $leased_area += $val->leased_area;
            }

            $plot_data = json_decode($val->plot_id);
            if (count($plot_data) > 0) {
                foreach ($plot_data as $plot) {
                    $plot_number = plot::where('plot_id', $plot)
                        ->pluck('plot_number')
                        ->first();
                    $plots .= $plot_number ? $plot_number . ',' : '';
                }
            }
        }
        $mouja_data = [
            'moujas' => substr($moujas, 0, strlen($moujas) - 1),
            'records' => substr($records, 0, strlen($records) - 1),
            'plots' => substr($plots, 0, strlen($plots) - 1),
            'ledgers' => substr($ledgers, 0, strlen($ledgers) - 1),
            'property_amount' => bangla_number($property_amount),
            'leased_area' => bangla_number($leased_area),
        ];
        return $mouja_data;
    }
}

if (!function_exists('masterplan_moujas')) {
    function masterplan_moujas($value)
    {
        $moujas = null;
        $records = null;
        $plots = null;
        $ledgers = null;
        $property_amount = 0;
        $masterplan_plot_total_area = 0;

        foreach ($value as $val) {
            $mouja = Mouja::where('mouja_id', $val->mouja_id)
                ->pluck('mouja_name')
                ->first();
            if ($mouja) {
                $moujas .= $mouja . ',';
            }

            if ($val->ledger_id) {
                $ledger = ledger::where('id', $val->ledger_id)
                    ->pluck('ledger_number')
                    ->first();
                $ledgers .= $ledger ? $ledger . ',' : '';
            }

            if ($val->record_name == 1) {
                $records = 'সি.এস' . ',';
            }

            if ($val->record_name == 2) {
                $records = 'এস.এ' . ',';
            }

            if ($val->record_name == 3) {
                $records = 'আর.এস' . ',';
            }

            if ($val->masterplan_id) {
                $masterplan_plot_total_area = MasterPlanPlot::where('masterplan_id', $val->masterplan_id)->sum('total_sft');
            }

            $plot_data = json_decode($val->plot_id);
            if (count($plot_data) > 0) {
                foreach ($plot_data as $plot) {
                    $plot_number = plot::where('plot_id', $plot)
                        ->pluck('plot_number')
                        ->first();
                    $plots .= $plot_number ? $plot_number . ',' : '';
                }
            }
        }

        $mouja_data = [
            'moujas' => substr($moujas, 0, strlen($moujas) - 1),
            'records' => substr($records, 0, strlen($records) - 1),
            'masterplan_plots' => substr($plots, 0, strlen($plots) - 1),
            'ledgers' => substr($ledgers, 0, strlen($ledgers) - 1),
            'masterplan_plot_total_area' => $masterplan_plot_total_area,
        ];
        return $mouja_data;
    }
}
/* agency license mouja */
if (!function_exists('agency_license_moujas')) {
    function agency_license_moujas($value)
    {
        $divisions = null;
        $districts = null;
        $kacharis = null;
        $upazilas = null;
        $stations = null;
        $moujas = null;
        $records = null;
        $plots = null;
        $ledgers = null;
        $property_amount = 0;
        $leased_area = 0;

        foreach ($value as $val) {
            $division = Division::where('division_id', $val->division_id)
                ->pluck('division_name')
                ->first();
            $divisions .= $division . ',';

            $district = District::where('district_id', $val->district_id)
                ->pluck('district_name')
                ->first();
            $districts .= $district . ',';

            $kachari = Kachari::where('kachari_id', $val->kachari_id)
                ->pluck('kachari_name')
                ->first();
            $kacharis .= $kachari . ',';

            $upazila = Upazila::where('upazila_id', $val->upazila_id)
                ->pluck('upazila_name')
                ->first();
            $upazilas .= $upazila . ',';

            $station = Station::where('station_id', $val->station_id)
                ->pluck('station_name')
                ->first();
            $stations .= $station . ',';

            $mouja = Mouja::where('mouja_id', $val->mouja_id)
                ->pluck('mouja_name')
                ->first();
            $moujas .= $mouja . ',';
            if ($val->ledger_id) {
                $ledger = ledger::where('id', $val->ledger_id)
                    ->pluck('ledger_number')
                    ->first();
                $ledgers .= $ledger ? $ledger . ',' : '';
            }

            if ($val->record_name == 1) {
                $records = 'সি.এস' . ',';
            }
            if ($val->record_name == 2) {
                $records = 'এস.এ' . ',';
            }
            if ($val->record_name == 3) {
                $records = 'আর.এস' . ',';
            }

            if ($val->property_amount) {
                $property_amount += $val->property_amount;
            }

            if ($val->leased_area) {
                $leased_area += $val->leased_area;
            }

            $plot_data = json_decode($val->plot_id);
            if (count($plot_data) > 0) {
                foreach ($plot_data as $plot) {
                    $plot_number = plot::where('plot_id', $plot)
                        ->pluck('plot_number')
                        ->first();
                    $plots .= $plot_number ? $plot_number . ',' : '';
                }
            }
        }
        $mouja_data = [
            'divisions' => substr($divisions, 0, strlen($divisions) - 1),
            'districts' => substr($districts, 0, strlen($districts) - 1),
            'kacharis' => substr($kacharis, 0, strlen($kacharis) - 1),
            'upazilas' => substr($upazilas, 0, strlen($upazilas) - 1),
            'stations' => substr($stations, 0, strlen($stations) - 1),
            'moujas' => substr($moujas, 0, strlen($moujas) - 1),
            'records' => substr($records, 0, strlen($records) - 1),
            'plots' => substr($plots, 0, strlen($plots) - 1),
            'ledgers' => substr($ledgers, 0, strlen($ledgers) - 1),
            'property_amount' => bangla_number($property_amount),
            'leased_area' => bangla_number($leased_area),
        ];
        return $mouja_data;
    }
}


if (!function_exists('commercial_license_moujas')) {
    function commercial_license_moujas($value)
    {
        $moujas = null;
        $records = null;
        $ledgers = null;
        $property_amount = 0;
        $leased_area = 0;
        $plot_length = [];
        $plot_width = [];
        $masterplan_no = null;
        $led = [];
        $moj = [];
        $rec = [];
        $com_license_plots_new = [];

        foreach ($value->pluck('plot_id')->toArray() as $dat) {
            $com_license_plots_new = array_merge($com_license_plots_new, json_decode($dat, true));
        }
        $com_license_plots = MasterPlanPlot::whereIn('id', $com_license_plots_new)
            ->get()
            ->pluck('plot_number')->toArray();
        $com_license_plots = implode(", ", $com_license_plots);

        foreach ($value as $val) {
            $mouja_data = MasterPlanMouja::where('masterplan_id', $val->masterplan_id)->get();

            if ($mouja_data) {
                foreach ($mouja_data as $mouja) {
                    if ($mouja && $mouja->mouja_id != null) {
                        $moj[] = Mouja::where('mouja_id', $mouja->mouja_id)->pluck('mouja_name')->first();
                    }

                    if ($mouja && $mouja->record_name != null) {
                        $rec[] = $mouja->record->record_name;
                    }

                    if ($mouja && $mouja->ledger_id != null) {
                        $ledger = ledger::where('id', $mouja->ledger_id)
                            ->pluck('ledger_number')
                            ->first();

                        $led[] = $ledger ? $ledger : '';
                    }
                }
            }

            if ($val->masterplan_id) {
                $masterplan = MasterPlan::where('id', $val->masterplan_id)
                    ->pluck('masterplan_no')
                    ->first();
                $masterplan_no .= $masterplan . ',';
            }

            if ($val->leased_area) {
                $leased_area += $val->leased_area;
            }

            if ($val->plot_length) {
                $plot_length[] = $val->plot_length;
            }

            if ($val->plot_width) {
                $plot_width[] = $val->plot_width;
            }

            if ($val->masterplan_id) {
                $masterPlanPlot = MasterPlanPlot::where('masterplan_id', $val->masterplan_id)->get();
                if ($masterPlanPlot) {
                    $property_amount = $masterPlanPlot->sum('total_sft');
                }
            }
        }

        $ledgers = array_unique($led);
        $moujas = array_unique($moj);
        $records = array_unique($rec);

        $mouja_data = [
            'moujas' => implode(', ', $moujas),
            'records' => implode(', ', $records),
            'ledgers' => implode(', ', $ledgers),
            'com_license_plots' => $com_license_plots,
            'property_amount' => $property_amount,
            'plot_length' => implode(', ', $plot_length),
            'plot_width' => implode(', ', $plot_width),
            'leased_area' => $leased_area,
            'masterplan_no' => substr($masterplan_no, 0, strlen($masterplan_no) - 1),
        ];
        return $mouja_data;
    }
}

if (!function_exists('dd_info')) {
    function dd_info($value)
    {
        $dd_no = '';
        $dd_vat = '';
        $dd_tax = '';
        $bank_name = '';
        $dd_date = '';
        $total = null;
        $j1_date = '';
        $dd_j1 = '';

        foreach ($value as $key => $dd_value) {
            if ($dd_value->dd_no) {
                $dd_no .= $dd_value->dd_no . ',';
            }
            if ($dd_value->dd_vat) {
                $dd_vat .= $dd_value->dd_vat . ',';
            }
            if ($dd_value->dd_tax) {
                $dd_tax .= $dd_value->dd_tax . ',';
            }
            if ($dd_value->bank_name) {
                $bank_name .= $dd_value->bank_name . ',';
            }
            if ($dd_value->dd_date) {
                $dd_date .= date('F j, Y', strtotime($dd_value->dd_date)) . ',';
            }
            if ($dd_value->total) {
                $total += $dd_value->total;
            }
            if ($dd_value->j1) {
                $dd_j1 .= $dd_value->j1 . ',';
            }
            if ($dd_value->j1_date) {
                $j1_date .= date('F j, Y', strtotime($dd_value->j1_date)) . ',';
            }
        }

        $data = [
            'dd_no' => substr($dd_no, 0, strlen($dd_no) - 1),
            'dd_vat' => substr($dd_vat, 0, strlen($dd_vat) - 1),
            'dd_tax' => substr($dd_tax, 0, strlen($dd_tax) - 1),
            'bank_name' => substr($bank_name, 0, strlen($bank_name) - 1),
            'dd_date' => substr($dd_date, 0, strlen($dd_date) - 1),
            'total' => substr($total, 0, strlen($total) - 1),
            'dd_j1' => substr($dd_j1, 0, strlen($dd_j1) - 1),
            'j1_date' => substr($j1_date, 0, strlen($j1_date) - 1),
        ];
        return $data;
    }
}

if (!function_exists('bangla_number')) {
    function bangla_number($int)
    {
        $engNumber = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
        $bangNumber = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
        $converted = str_replace($engNumber, $bangNumber, $int);
        return $converted;
    }
}

if (!function_exists('english_number')) {
    function english_number($int)
    {
        $bangNumber = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
        $engNumber = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

        $converted = str_replace($bangNumber, $engNumber, $int);
        return $converted;
    }
}

if (!function_exists('bangla_month')) {
    function bangla_month($value)
    {
        $fromDate = null;
        $toDate = null;
        $engMonth = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $bangMonth = ['বৈশাখ', 'জ্যৈষ্ঠ', 'আষাঢ়', 'শ্রাবণ', 'ভাদ্র', 'আশ্বিন', 'কার্তিক', 'অগ্রহায়ণ', 'পৌষ', 'মাঘ', 'ফাল্গুন', 'চৈত্র'];
        $converted = str_replace($engMonth, $bangMonth, $value);
        return $converted;
    }
}

if (!function_exists('date_en_to_bn')) {
    function date_en_to_bn($date)
    {
        $year = date('Y', strtotime($date));
        $month = date('M', strtotime($date));
        $day = date('d', strtotime($date));
        $bn_date = bangla_number($day) . ' ' . bangla_month($month) . ', ' . bangla_number($year);
        return $bn_date;
    }
}

if (!function_exists('bangla_year')) {
    function bangla_year($value)
    {
        $yearData = explode('-', $value);
        $fromDate = null;
        $toDate = null;
        foreach ($yearData as $key => $year) {
            if ($year && $key == 0) {
                $valOne = $year - 593;
                $fromDate = bangla_number($valOne);
            }
            if ($year && $key == 1) {
                $valTwo = $year - 593;
                $toDate = bangla_number($valTwo);
            }
        }

        if ($fromDate && $toDate) {
            return $fromDate . '-' . $toDate;
        }

        return ['fromDate' => $fromDate, 'toDate' => $toDate];
    }
}

if (!function_exists('license_bangla_year')) {
    function license_bangla_year($value)
    {
        $yearData = explode('-', $value);
        $fromDate = null;
        $toDate = null;
        foreach ($yearData as $key => $year) {
            if ($year && $key == 0) {
                $valOne = $year - 593;
                $fromDate = bangla_number($valOne);
            }
            if ($year && $key == 1) {
                $valTwo = $year - 593;
                $toDate = bangla_number($valTwo);
            }
        }

        return ['fromDate' => $fromDate, 'toDate' => $toDate];
    }
}

if (!function_exists('last_payment_year')) {
    function last_payment_year($value)
    {
        $yearData = explode('-', $value);
        $fromDate = null;
        $toDate = null;

        foreach ($yearData as $key => $year) {
            if ($year && $key == 0) {
                $fromDate = $year;
            }
            if ($year && $key == 1) {
                $toDate = $year;
            }
        }

        return ['fromDate' => $fromDate, 'toDate' => $toDate];
    }
}

if (!function_exists('balam_year')) {
    function balam_year($value, $type)
    {
        $license_date = null;
        $created_at = null;
        $from_date = null;
        $to_date = null;

        foreach ($value as $balam) {
            if ($type == 'agriculture' || $type == 'pond') {
                if ($balam->from_date) {
                    $license_date = bangla_year($balam->license_date);
                    $from_date = date_en_to_bn($balam->from_date);
                    $to_date = date_en_to_bn($balam->to_date);
                }
            } else {
                $license_date = date('F j, Y', strtotime($balam->license_date));
                $from_date = date('F j, Y', strtotime($balam->from_date));
                $to_date = date('F j, Y', strtotime($balam->to_date));
            }
            if ($balam->created_at) {
                $created_at = date('d-m-y', strtotime($balam->created_at));
            }
        }

        return [
            'license_date' => $license_date,
            'created_at' => $created_at,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ];
    }
}

if (!function_exists('license_area')) {
    function license_area($license)
    {
        return [
            "land_map_north" => $license->land_map_north ?? "N/A",
            "land_map_south" => $license->land_map_west ?? "N/A",
            "land_map_east" => $license->land_map_east ?? "N/A",
            "land_map_west" => $license->land_map_south ?? "N/A",
            "land_map_kilo" => $license->land_map_kilo ?? "N/A"
        ];
    }
}
