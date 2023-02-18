<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 10px;
            /* border: 1px solid #eee; */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 11px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: black;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-right: none;
        }

        .invoice-box table td {
            padding-left: 5px;
            padding-right: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.item td {
            border: solid 1px;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            body {
                height: 842px;
                width: 595px;
                margin-left: auto;
                margin-right: auto;
            }

            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        @media print {
            .noprint {
                display: none;
            }
        }


        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

        .row button {
            width: 80px;
            height: 40px;
            /* color: white; */
            /* border-radius: 4px; */
            /* background: rgb(66, 184, 221); */
        }
    </style>
</head>

<body>
    <div class="noprint">
        <div class="row" style="float: right">
            <button onclick="window.print()" class="print-button"><span class="fas fa-print" aria-hidden="true"></span>Print</button>
            <button> <a href="/" class=""><span class="fas fa-print" aria-hidden="true"></span>Cancel</a></button>
        </div>
    </div>

    @php
        $dd_ji = $license_details->license_dd_info['dd_j1'];
        $j1_date = $license_details->license_dd_info['j1_date'];
        $dd_date = $license_details->license_dd_info['dd_date'];
        $bank_name = $license_details->license_dd_info['bank_name'];
        $dd_no = $license_details->license_dd_info['dd_no'];
        $dd_vat = $license_details->license_dd_info['dd_vat'];
        $dd_tax = $license_details->license_dd_info['dd_tax'];
        $dd_j1_no = null;
        $j1_single = explode(',', $dd_ji);
        if ($j1_single && count($j1_single) > 0) {
            $dd_j1_no = $j1_single[0];
        }
        $feedate = null;
        $j1_date_single = explode(',', $j1_date);
        if ($j1_date_single && count($j1_date_single) > 0) {
            $feedate = $j1_date_single[0] . $j1_date_single[1];
        }
    @endphp
    <div class="invoice-box">
        <table style="border: none; padding:0px;">
            <tr>
                <td class="title" style="vertical-align: bottom; font-size:14px;">
                    লাইসেন্সীর কপি </td>
                <td>
                    <!-- <img src="{{ asset('images/vc-80.png') }}" /> -->
                    {!! QrCode::size(60)->generate($license_details->generate_url) !!}
                </td>
            </tr>
        </table>

        <table cellpadding="0" cellspacing="0" style="margin-bottom: 20px">
            <tr>
                <td colspan="4" style="text-align: center; font-weight: bold; font-size: 16px;">
                    ভূ-সম্পত্তি বিভাগ বাংলাদেশ রেলওয়ে
                </td>
            </tr>
            <tr class="item last">
                <td colspan="2" style="border-right:none;">লাইসেন্স নং:{{ $license_details->license_no ?? 'N/A' }}
                </td>
                @if ($license_details->license_type == 'সংস্থা')
                    <td colspan="2" style="border-left:none;">জি/১ রশিদ
                        নং:{{ $dd_j1_no ?? 'N/A' }},
                        তারিখ:{{ $feedate ? $feedate : 'N/A' }}
                    </td>
                @else
                    <td colspan="2" style="border-left:none;">জি/১ রশিদ
                        নং:{{ $dd_j1_no ?? 'N/A' }},
                        তারিখ:{{ $feedate ? $feedate : 'N/A' }}
                    </td>
                @endif
            </tr>

            <tr class="item last">
                @php
                $license_date = license_bangla_year($license_details->license_date);
                @endphp
                <td colspan="2" style="border-right:none;">সময়কাল: ১লা
                    বৈশাখ {{ $license_date['fromDate'] }} হতে ৩০শে চৈত্র {{ $license_date['toDate'] }}</td>
                <td colspan="2" style="border-left:none;">লাইসেন্স ধরন: {{ $license_details->license_type }}</td>
            </tr>

            <tr class="item last">
                <td style="border-right:none; border-bottom:none;">
                    @if($license_details->license_type == 'সংস্থা')
                    @foreach ($license_owner as $owner)
                    নাম:{{ $owner->name ?? 'N/A' }}<br>

                    ঠিকানা:{{ $owner->address ?? 'N/A' }}
                    <br>
                    @endforeach

                    @else
                    @foreach ($license_owner as $owner)
                    নাম:{{ $owner->name ?? 'N/A' }}<br>

                    @if ($owner->father_name ?? 'N/A')
                    পিতা:{{ $owner->father_name ?? 'N/A' }}<br>
                    @else
                    স্বামী:{{ $owner->husband_name ?? 'N/A' }}<br>
                    @endif


                    ঠিকানা:{{ $owner->address ?? 'N/A' }}
                    <br>
                    @endforeach
                    @endif
                </td>

                <td style="border-bottom:none; text-align:left;">
                    @if ($license_details->license_type == 'সংস্থা')
                        জেলা: {{ $license_details->license_mouja['districts'] ?? 'N/A' }}<br>
                        উপজেলা: {{ $license_details->license_mouja['upazilas'] ?? 'N/A' }}<br>
                        স্টেশন: {{ $license_details->license_mouja['stations'] ?? 'N/A' }}<br>
                        মৌজা: {{ $license_details->license_mouja['moujas'] ?? 'N/A' }}<br>
                    @else
                        জেলা: {{ $license_details->license->district->district_name ?? 'N/A' }}<br>
                        উপজেলা: {{ $license_details->license->upazila->upazila_name ?? 'N/A' }}<br>
                        স্টেশন: {{ $license_details->license->station->station_name ?? 'N/A' }}<br>
                        মৌজা: {{ $license_details->license_mouja['moujas'] ?? 'N/A' }}<br>
                    @endif
                    @if ($license_details->license_type == 'বাণিজ্যিক')
                    মাস্টারপ্ল্যান নং: {{ $license_details->license_mouja['masterplan_no'] ?? 'N/A' }} <br>
                    মাস্টারপ্ল্যানের প্লট নং: {{ $license_details->license_mouja['masterplan_plots'] ?? 'N/A' }}
                    <br>
                    @else
                    খতিয়ান নং: {{ $license_details->license_mouja['ledgers'] ?? 'N/A' }}<br>
                    রেকর্ড: {{ $license_details->license_mouja['records'] ?? 'N/A' }}<br>
                    দাগ: {{ $license_details->license_mouja['plots'] ?? 'N/A' }}<br>
                    @endif

                    @if($license_details->license_type == 'সংস্থা')
                    জমির পরিমান: {{ $license_details->license_mouja['property_amount'] . ' বর্গফুট' ?? 'N/A' }}
                    @else
                        জমির পরিমান: {{ $license_details->license_mouja['leased_area'] . ' বর্গফুট' ?? 'N/A' }}
                    @endif
                </td>
                <td style="width:200px; border-left:none;">
                    লাইসেন্স ফি <br>
                    ভ্যাট <br>
                    উৎস কর <br>
                    তারিখ: {{ $dd_date ? date('F j, Y', strtotime($dd_date)) : 'N/A' }}<br>
                    ব্যাংক: {{ $bank_name ?? 'N/A' }}<br>
                </td>
                <td style="width:100px; border-left:none; text-align:center;">
                    {{ $license_details->license_fee ? $license_details->license_fee . '/-' : '' }}<br>
                    {{ $license_details->vat ? $license_details->vat . '/-' : '' }}<br>
                    {{ $license_details->tax ? $license_details->tax . '/-' : '' }}<br>
                </td>
            </tr>
            <?php $total_amount = $license_details->total_fee; ?>
            <tr class="item last">
                <td colspan="1" style="border-right:none; border-top:none;"></td>
                <td colspan="1" style="border-top:none;"></td>
                <td colspan="1" style="border-left:none; text-align:right;">সর্বমোট</td>
                <td colspan="1" style="border-left:none;  text-align:center;">
                    {{ $total_amount ? $total_amount . '/-' : '' }}
                </td>
            </tr>

            <tr class="item">
                <td colspan="2" style="border-right:none; font-weight: bold;">মো:মোস্তাফিজার রাহমান, ফিল্ড কানুনগো,
                    ০১ নং কাচারী কর্তৃক আদায়কৃত</td>
                <td colspan="2" style="border-left:none;">কথায়:
                    {{ $total_amount ? number_to_word('' . $total_amount . '', 'bn') : '' }}
                </td>
            </tr>
        </table>
    </div>

</body>

</html>