<?php

namespace App\Models\Backend;

use App\Models\Backend\plot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ledger extends Model
{
    public $timestamps = false;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['division_id', 'kachari_id', 'district_id', 'upazila_id', 'station_id', 'mouja_id', 'section_id', 'record_name', 'ledger_number', 'owner_name', 'owner_address', 'comments', 'documents', 'user_id', 'user_status', 'comments_byDataEntry'];

    protected static $ledger;
    protected static $ledgerImage;
    protected static $imageDirectory;
    protected static $imageName;
    protected static $imageUrl;
    public static $bn = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
    public static $en = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

    public static function saveImage($request)
    {
        self::$ledgerImage = $request->file('documents');
        self::$imageName = 'ledger-files' . time() . '.' . self::$ledgerImage->getClientOriginalExtension();
        self::$imageDirectory = 'ledger-files/';
        self::$ledgerImage->move(self::$imageDirectory, self::$imageName);
        return self::$imageDirectory . self::$imageName;
    }
    public static function bn2en($number)
    {
        return str_replace(self::$bn, self::$en, $number);
    }

    public static function en2bn($number)
    {
        return str_replace(self::$en, self::$bn, $number);
    }

    public static function newledger($request)
    {
        self::$ledger = new ledger();
        self::$ledger->division_id = $request->division_id;
        self::$ledger->kachari_id = $request->kachari_id;
        self::$ledger->district_id = $request->district_id;
        self::$ledger->upazila_id = $request->upazila_id;
        self::$ledger->station_id = $request->station_id;
        self::$ledger->mouja_id = $request->mouja_id;
        self::$ledger->section_id = $request->section_id;
        self::$ledger->record_name = $request->record_name;
        self::$ledger->ledger_number = self::bn2en($request->ledger_number);
        self::$ledger->owner_name = $request->owner_name;
        self::$ledger->owner_address = $request->owner_address;
        self::$ledger->comments = $request->comments;
        self::$ledger->documents = self::saveImage($request);
        self::$ledger->user_id = $request->user_id;
        self::$ledger->user_status = $request->user_status;
        self::$ledger->comments_byDataEntry = $request->comments_byDataEntry;
        self::$ledger->save();
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'division_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    public function kachari()
    {
        return $this->belongsTo(Kachari::class, 'kachari_id', 'kachari_id');
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id', 'upazila_id');
    }

    public function landType()
    {
        return $this->belongsTo(LandType::class, 'land_type_id', 'land_type_id');
    }

    public function mouja()
    {
        return $this->belongsTo(Mouja::class, 'mouja_id', 'mouja_id');
    }

    public function plot()
    {
        return $this->hasMany(plot::class);
    }

    public function record()
    {
        return $this->belongsTo(Record::class, 'record_name', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'section_id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'station_id');
    }

    public function acquisition()
    {
        return $this->hasMany(Acquisition::class);
    }

    public function plotamount()
    {
        return $this->hasMany(plot::class, 'ledger_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
