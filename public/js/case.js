(function ($){
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var i = 1;
    $("body")
    .on("click","#addwhole-divisin",function(e){
        //alert('hi');
        e.preventDefault();
        var division = $(".division_id").html();
        var district = $(".district_id").html();
        var kachari = $(".kachari_id").html();
        var upazila = $(".upazila_id").html();
        var station = $(".station_id").html();
        var mouja = $(".mouja_id2").html();
        var record = $(".record_name").html();
        var ledger = $(".ledger_id").html();
        var plot = $(".plot_id").html();

        console.log(mouja);
        ++i;
       $("#dynamic-wholedivision").append(

         ` <div class="division" id="division_${i}">
        <div class="col-12 division">
        <div class="row">
            <div class="col-md-2 text-right">
                <div class="form-group">
                    <label for="division_id">বিভাগের নাম:</label>
                </div>
            </div>
           
            <div class="col-md-3">
                <select required id="division_id_${i}" class="form-control division_id" name="mouja[${i}][division_id]" data-target="#kachari_id_${i}" required>
                    
                  ${division}
                </select>
            </div>
            <div class="col-md-2 ">
            <button type="button"
            class="btn btn-outline-danger remove-division"><i class="fa fa-trash"
                    aria-hidden="true"></i></button>
           </div>
        </div>

        <div class="row">
            <div class="col-md-2 text-right">
                <div class="form-group">
                    <label for="kachari_id">কাচারীর নাম:</label>
                </div>
            </div>
            <div class="col-md-3">
                <select required id="kachari_id_${i}" class="form-control kachari_id" name="mouja[${i}][kachari_id]" data-target="#district_id_${i}" required>
                <option selected disabled>কাচারীর বাছাই করুন</option>
                ${kachari}
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 text-right">
                <div class="form-group">
                    <label for="district_id">জেলার নাম:</label>
                </div>
            </div>
            <div class="col-md-3">
                <select required class="form-control district_id" id="district_id_${i}" name="mouja[${i}][district_id]" data-target="#upazila_id_${i}" required>
                    <option selected disabled>জেলা বাছাই করুন</option>
                    ${district}
                </select>
            </div>
        </div>


        <div class="row">
            <div class="col-md-2 text-right">
                <div class="form-group">
                    <label for="upazila_id">উপজেলার নাম:</label>
                </div>
            </div>
            <div class="col-md-3">
                <select required class="form-control upazila_id" id="upazila_id_${i}" name="mouja[${i}][upazila_id]"  data-target="#station_id_${i}" required>
                    <option selected disabled>উপজেলা বাছাই করুন</option>
                    ${upazila}
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 text-right">
                <div class="form-group">
                    <label for="station_id">স্টেশনের নাম:</label>
                </div>
            </div>
            <div class="col-md-3">
                <select required class="form-control station_id" id="station_id_${i}" name="mouja[${i}][station_id]" data-target="#mouja_id_${i}" required>
                    <option selected disabled>স্টেশন বাছাই করুন</option>
                    ${station}
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered" id="license_moujas">
                <tr>
                    <th>মৌজার নাম</th>
                    <th>রেকর্ডের নাম</th>
                    <th>খতিয়ান নম্বর</th>
                    <th>দাগ নম্বর</th>
                    <th>লীজকৃত জমি পরিমাণ</th>
                   
                    
                </tr>
                <tr>
                    <td style="width: 10%;">
                        <select class="form-control mouja_id2" id="mouja_id_${i}" data-target="#record_name_${i}" name="mouja[${i}][mouja_id]" required>
                           
                            ${mouja}
                        </select>
                    </td>

                    <td style="width: 10%;">
                        <select class="form-control record_name" id="record_name_${i}" data-target="#ledger_id_${i}" name="mouja[${i}][record_name]" data-previous="mouja_id_${i}">
                          
                            ${record}
                        </select>
                    </td>

                    <td style="width: 10%;">
                        <select class="form-control ledger_id" id="ledger_id_${i}" data-target="#plot_id_${i}" name="mouja[${i}][ledger_id]">
                            <option selected disabled>খতিয়ান নম্বর</option>
                            ${ledger}
                        </select>
                    </td>

                    <td style="width: 20%;">
                        <select class="form-control js-example-basic-single plot_id" id="plot_id_${i}" name="mouja[${i}][plot_id][]" multiple="multiple" data-target="#mouja_total_amount_${i}">
                            <option selected disabled>দাগ নম্বর</option>
                        </select>
                    </td>

                    <td style="width: 10%;">
                        <input type="text" name="mouja[${i}][property_amount]" id="mouja_total_amount1_${i}" placeholder="লীজকৃত জমি (বর্গফুট)" class="form-control" />
                    </td>

                    
                   
                </tr>

            </table>
        </div>
    </div>




</div>
</div>
`
       );

       $(".js-example-basic-single").select2();
    })
    .on("change", ".division_id", function () {
        var get_target = $(this).data('target');
        $(get_target).html("");
        var idDivision = this.value;
       // $(".kachari_id").html("");

        var route = $("#kachari").val();
        //alert(route);
        $.ajax({
            url: route,
            type: "POST",
            data: {
                division_id: idDivision,
                _token: $("meta[name=csrf-token]").attr("content"),
            },
            dataType: "json",
            success: function (result) {
                $(get_target).html(
                    '<option disabled selected value="">কাচারী বাছাই করুন</option>'
                );
                $.each(result.kachari, function (key, value) {
                    $(get_target).append(
                        '<option value="' +
                        value.kachari_id +
                        '">' +
                        value.kachari_name +
                        "</option>"
                    );
                });
                // $(".district_id").html(
                //     '<option disabled selected value="">জেলা বাছাই করুন</option>'
                // );
            },
        });
    })


    .on("change", ".kachari_id", function () {
        var get_target = $(this).data('target');
        $(get_target).html("");
         //alert(get_target);
        var idKachari = this.value;
       // $(".district_id").html("");
        var route = $("#district").val();
        //alert(route);

        $.ajax({
            url: route,
            type: "POST",
            data: {
                kachari_id: idKachari,
                _token: $("meta[name=csrf-token]").attr("content"),
            },
            dataType: "json",
            success: function (res) {
                $(get_target).html(
                    '<option disabled selected value="">জেলা বাছাই করুন</option>'
                );
                $.each(res.district, function (key, value) {
                    $(get_target).append(
                        '<option value="' +
                        value.district_id +
                        '">' +
                        value.district_name +
                        "</option>"
                    );
                });
                // $(".upazila_id").html(
                //     "<option disabled selected>উপজেলা বাছাই করুন</option>"
                // );
            },
        });
    })
    .on("change", ".district_id", function () {
        var get_target = $(this).data('target');
        $(get_target).html("");
        var idDistrict = this.value;
        //$(".upazila_id").html("");
        var route = $("#upazila").val();

        $.ajax({
            url: route,
            type: "POST",
            data: {
                district_id: idDistrict,
                _token: $("meta[name=csrf-token]").attr("content"),
            },
            dataType: "json",
            success: function (res1) {
                $(get_target).html(
                    "<option disabled selected>উপজেলা বাছাই করুন</option>"
                );
                $.each(res1.upazila, function (key, value) {
                    $(get_target).append(
                        '<option value="' +
                        value.upazila_id +
                        '">' +
                        value.upazila_name +
                        "</option>"
                    );
                });
            },
        });
    })
    .on("change", ".upazila_id", function () {
        var get_target = $(this).data('target');
        $(get_target).html("");
        var idUpazila = this.value;
       // alert(get_target);
       // $(".station_id").html("");
        var route = $("#station").val();

        $.ajax({
            url: route,
            type: "POST",
            data: {
                upazila_id: idUpazila,
                _token: $("meta[name=csrf-token]").attr("content"),
            },
            dataType: "json",
            success: function (res2) {
                $(get_target).html(
                    "<option disabled selected>স্টেশন বাছাই করুন</option>"
                );
                $.each(res2.station, function (key, value) {
                    $(get_target).append(
                        '<option value="' +
                        value.station_id +
                        '">' +
                        value.station_name +
                        "</option>"
                    );
                });
                // $(".mouja_id2").html(
                //     "<option disabled selected>মৌজা বাছাই করুন</option>"
                // );
            },
        });
    })

    .on("change", ".station_id", function () {
        var get_target = $(this).data('target');
        $(get_target).html("");
        var idStation = $(this).val();
       // $(".mouja_id2").html("");
        var get_data_key = $(this).data('key');

        var route = $("#mouza").val();

        if (get_data_key !== undefined && get_data_key.length && get_data_key == "masterplan") {
            var route = $("#masterplan").val();
        }

        $.ajax({
            url: route,
            type: "POST",
            data: {
                station_id: idStation,
                _token: $("meta[name=csrf-token]").attr("content"),
            },
            dataType: "json",
            success: function (res3) {

                if (get_data_key == "masterplan") {
                    $(".masterplan_no").html(
                        "<option disabled selected>মাস্টারপ্লান বাছাই করুন</option>"
                    );
                    $.each(res3.masterplan, function (key, value) {
                        $(get_target).append(
                            '<option value="' + value.id +
                            '">' + value.masterplan_no + "</option>"
                        );
                    });

                } else {

                    $(get_target).html(
                        "<option disabled selected>মৌজা বাছাই করুন</option>"
                    );
                    $.each(res3.mouja, function (key, value) {
                        $(get_target).append(
                            '<option value="' +
                            value.mouja_id +
                            '">' +
                            value.mouja_name +
                            "</option>"
                        );
                    });
                }
            },
        });
    })
    .on("change", ".mouja_id2", function () {
        var get_target = $(this).data('target');
        //alert(get_target);
        $(get_target).html("");
        var route = $("#record").val();
        //alert(route);
        $.ajax({
            url: route,
            type: "POST",
            data: {
                _token: $("meta[name=csrf-token]").attr("content"),
            },
            dataType: "json",
            success: function (res3) {
                $(get_target).html(
                    "<option selected disabled>রেকর্ড বাছাই করুন</option>"
                );
                $.each(res3.record, function (key, value) {
                    $(get_target).append(
                        '<option value="' +
                        value.id +
                        '">' +
                        value.record_name +
                        "</option>"
                    );
                });
            },
        });
    })

    // .on("change", ".mouja_id", function () {
    //     var get_target = $(this).data('target');
    //     //alert(get_target);
    //     $(get_target).html("");
    //     var route = $("#record").val();
    //     //alert(route);
    //     $.ajax({
    //         url: route,
    //         type: "POST",
    //         data: {
    //             _token: $("meta[name=csrf-token]").attr("content"),
    //         },
    //         dataType: "json",
    //         success: function (res3) {
    //             $(get_target).html(
    //                 "<option selected disabled>রেকর্ড বাছাই করুন</option>"
    //             );
    //             $.each(res3.record, function (key, value) {
    //                 $(get_target).append(
    //                     '<option value="' +
    //                     value.id +
    //                     '">' +
    //                     value.record_name +
    //                     "</option>"
    //                 );
    //             });
    //         },
    //     });
    // })

    .on("change", ".record_name", function () {
        var get_target = $(this).data('target');
        //alert(get_target);
        var previous_mouja = $(this).data('previous');
        // alert(previous_mouja);
        $(get_target).html("");
        var idRecord = this.value;
       // alert(idRecord);

        var route = $("#ledger").val();
        //alert(route);

        $.ajax({
            url: route,
            type: "POST",
            data: {
                record_id: idRecord,
                mouja_id: $('#' + previous_mouja).children("option:selected").val(),
                _token: $("meta[name=csrf-token]").attr("content"),
            },
            dataType: "json",
            success: function (res3) {
                $(get_target).html(
                    "<option selected disabled>রেকর্ড বাছাই করুন</option>"
                );

                $.each(res3.ledger, function (key, value) {
                    $(get_target).append(
                        '<option value="' +
                        value.id +
                        '">' +
                        value.ledger_number +
                        "</option>"
                    );
                });
                // record_name = res3.ledger;
            },
        });
    })
    .on("change", ".ledger_id", function () {
        var get_target = $(this).data('target');
        $(get_target).html("");

        var idLedger = this.value;
        var route = $("#plot").val();
        $.ajax({
            url: route,
            type: "POST",
            data: {
                ledger_id: idLedger,
                _token: $("meta[name=csrf-token]").attr("content"),
            },
            dataType: "json",
            success: function (res3) {
                $.each(res3.plot, function (key, value) {
                    $(get_target).append(
                        '<option value="' +
                        value.plot_id +
                        '" land-amount="' + value.land_amount + '">' +
                        value.plot_number +
                        "</option>"
                    );
                });

            },
        });

        $(get_target).select2();
    })


    $("body")
    .on('click', '.remove-division', function () {
        $(this).parents('.division').remove();
    });


})(jQuery);



