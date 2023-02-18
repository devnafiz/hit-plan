<!DOCTYPE html>
<html lang="bn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @media {
            @print {
                body {
                    font-family: nikosh;
                    font-size: 17px;
                }

                table,
                tr,
                td {
                    border: 1px solid #ddd;
                    border-collapse: collapse;
                    padding: 10px;
                }

                thead tr,
                th {
                    border: 1px solid #ddd;
                }

                tbody tr:nth-child(even) th {
                    background-color: #25c;
                }
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="table-responsive">
                    <table id="" class="table table-bordered table-striped"
                        style="overflow-x: auto; width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">নং</th>
                                <th class="text-center align-middle">লাইসেন্স নং</th>
                                <th class="text-center align-middle">লাইসেন্সীর তথ্য</th>
                                <th class="text-center align-middle">কাচারী নাম</th>
                                <th class="text-center align-middle">স্টেশনের নাম</th>
                                <th class="text-center align-middle">তফসিল</th>
                                <th class="text-center align-middle">সর্বশেষ লাইসেন্স ফি পরিশোধের সময়কাল</th>
                                <th class="text-center align-middle">অনুমোদনর তারিখ</th>
                                <th class="text-center align-middle">চৌহদ্দি সংক্রান্ত তথ্য</th>
                            </tr>
                        </thead>
                        @if ($searchResult)
                            <tbody>
                                @forelse ($searchResult as $key => $serValue)
                                    <?php
                                    $sr_no = null;
                                    $license_date_from = date('Y d M');
                                    $license_date_to = date('Y d M');
                                    ?>
                                    <tr>
                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                        <td class="text-center align-middle"><a
                                                href="{{ route('admin.agriculture.show', $serValue) }}">{{ $serValue->generated_id }}</a>
                                        </td>
                                        <td class="" style="width: 100px;">
                                            @forelse ($serValue->agriOwner as $owner)
                                                <p>
                                                    <strong>লাইসেন্সীর নাম: </strong>{{ $owner->name ?? 'N/A' }}<br>
                                                    @if ($owner->father_name)
                                                        <strong>পিতার নাম:
                                                        </strong>{{ $owner->father_name ?? 'N/A' }}<br>
                                                    @endif
                                                    @if ($owner->husband_name)
                                                        <strong>স্বামীর নাম:
                                                        </strong>{{ $owner->husband_name ?? 'N/A' }}<br>
                                                    @endif
                                                    <strong>ঠিকানা: </strong>{{ $owner->address }}<br>
                                                    <strong>মোবাইল: </strong>{{ $owner->phone }}<br>
                                                    <strong>এনআইডি: </strong>{{ $owner->nid }}<br>
                                                </p>
                                            @empty
                                            @endforelse
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $serValue->kachari->kachari_name ?? 'N/A' }}
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $serValue->station->station_name ?? 'N/A' }}
                                        </td>

                                        <td class="" style=" table-layout: fixed; width: 180px;">
                                            <strong>জেলা:
                                            </strong>{{ $serValue->district->district_name ?? 'N/A' }}<br>
                                            <?php $license_moujas = license_moujas($serValue->agriMoujas); ?>
                                            <strong>উপজেলা:
                                            </strong>{{ $serValue->upazila->upazila_name ?? 'N/A' }}<br>
                                            <strong>মৌজা: </strong>{{ $license_moujas['moujas'] ?? 'N/A' }}<br>
                                            <strong>খতিয়ান নং: </strong>{{ $license_moujas['ledgers'] ?? 'N/A' }}<br>
                                            <strong>দাগ নং: </strong>{{ $license_moujas['plots'] ?? 'N/A' }}<br>
                                            <strong>লাইসেন্সকৃত জমির পরিমান:
                                            </strong>{{ $license_moujas['leased_area'] . ' একর' ?? 'N/A' }}<br>
                                        </td>

                                        <td class="text-center align-middle">
                                            @if ($license_date_from && $license_date_to)
                                                {{ $license_date_from }}<strong> হইতে
                                                </strong>{{ $license_date_to }}
                                            @else
                                                N/A
                                            @endif
                                        </td>

                                        <td class="text-center align-middle">
                                            <h6>{{ $serValue->demand_notice_date ? date('F j, Y', strtotime($serValue->demand_notice_date)) : 'N/A' }}
                                            </h6>
                                        </td>
                                        <td class="text-center align-middle">
                                            @php
                                                $license = license_area($serValue);
                                            @endphp
                                            <strong>চৌহদ্দি উত্তর:</strong> {{ $license['land_map_north'] }}, <br>
                                            <strong>দক্ষিণ:</strong> {{ $license['land_map_south'] }}, <br>
                                            <strong>পূর্ব:</strong> {{ $license['land_map_east'] }}, <br>
                                            <strong>পশ্চিম:</strong> {{ $license['land_map_west'] }}, <br>
                                            <strong>কি.মি:</strong> {{ $license['land_map_kilo'] }}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
