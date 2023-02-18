<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $dt = Carbon::now();
        $orders = DB::table('orders')->select('*')->where('created_at', $dt->toDateString())->paginate(5);
        return view('admin.pages.report.order-report')->with('orders', $orders);
    }

    public function invoice_pdf()
    {

        $dt = Carbon::now();
        $orders = DB::table('orders')->select('*')->where('created_at', $dt->toDateString())->get();
        //return view('admin.pages.report.invoice', compact('orders'));
        $pdf = PDF::loadView('admin.pages.report.invoice', compact('orders'));
        return $pdf->stream('invoice.pdf');
    }
    public function invoice_pdf_large()
    {

        $dt = Carbon::now();
        $orders = DB::table('orders')->select('*')->where('created_at', $dt->toDateString())->get();
        //return view('admin.pages.report.invoice', compact('orders'));
        $pdf = PDF::loadView('admin.pages.report.invoice-large', compact('orders'));
        return $pdf->stream('invoice.pdf');
    }
    public function invoice_pdf_download()
    {
        $dt = Carbon::now();
        $orders = DB::table('orders')->select('*')->where('created_at', $dt->toDateString())->get();
        $filename = 'invoice_' . date('m-d-Y') . '.pdf';
        $dompdf = PDF::loadView('admin.pages.report.invoice', compact('orders'));
        return $dompdf->download($filename);
    }
}
