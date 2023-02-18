// (function ($) {
//     var current_fs, next_fs, previous_fs; //fieldsets
//     var opacity;
//     var current = 1;
//     var steps = $("fieldset").length;
//     setProgressBar(current);

//     $("body")
//         .on("click", ".next", function () {
//             current_fs = $(this).parent();
//             next_fs = $(this).parent().next();
//             //Add Class Active
//             $("#progressbar li")
//                 .eq($("fieldset").index(next_fs))
//                 .addClass("active");

//             //show the next fieldset
//             next_fs.show();

//             //hide the current fieldset with style
//             current_fs.animate({
//                 opacity: 0
//             }, {
//                 step: function (now) {
//                     // for making fielset appear animation
//                     opacity = 1 - now;

//                     current_fs.css({
//                         display: "none",
//                         position: "relative",
//                     });
//                     next_fs.css({
//                         opacity: opacity
//                     });
//                 },
//                 duration: 500,
//             });
//             setProgressBar(++current);
//         })
//         .on('change', "#district_permanent", function () {
//             var upazilla = JSON.parse($("#upazilla").val());
//             var selected_district = $(this).children("option:selected").val();
//             var upazilla_name = '';
//             upazilla.forEach(element => {
//                 if (element.district_id == selected_district) {
//                     upazilla_name += '<option value="' + element.id + '">' + element.name + '</option>';
//                 }
//             });

//             $('#police_station_permanent').html(upazilla_name);

//         })
//         .on('change', "#district_present", function () {
//             var upazilla = JSON.parse($("#upazilla").val());
//             var selected_district = $(this).children("option:selected").val();
//             var upazilla_name = '';

//             upazilla.forEach(element => {
//                 if (element.district_id == selected_district) {
//                     upazilla_name += '<option value="' + element.id + '">' + element.name + '</option>';
//                 }
//             });

//             $('#police_station_present').html(upazilla_name);
//         })
//         .on("click", ".previous", function () {
//             current_fs = $(this).parent();
//             previous_fs = $(this).parent().prev();
//             //Remove class active
//             $("#progressbar li")
//                 .eq($("fieldset").index(current_fs))
//                 .removeClass("active");

//             //show the previous fieldset
//             previous_fs.show();

//             //hide the current fieldset with style
//             current_fs.animate({
//                 opacity: 0
//             }, {
//                 step: function (now) {
//                     // for making fielset appear animation
//                     opacity = 1 - now;

//                     current_fs.css({
//                         display: "none",
//                         position: "relative",
//                     });
//                     previous_fs.css({
//                         opacity: opacity
//                     });
//                 },
//                 duration: 500,
//             });
//             setProgressBar(--current);
//         })
//         .on("keyup", '#phon_validation', function () {
//             var valid = /^\d{0,11}(\.\d{0,2})?$/.test(this.value),
//                 val = this.value;

//             if (!valid) {
//                 console.log("Invalid input!");
//                 this.value = val.substring(0, val.length - 1);
//             }
//         })
//         .on('change', '#same_as', function () {
//             var village = $("#village_present").val();
//             var post = $("#post_office_present").val();
//             var district = $("#district_present").val();
//             var polistation = $("#police_station_present").html();

//             $("#village_permanent").val(village);
//             $("#post_office_permanent").val(post);
//             $("#police_station_permanent").val(district);
//             $("#police_station_permanent").html(polistation);
//             $("#police_station_permanent").val($("#police_station_present").val());
//         });

//     function setProgressBar(curStep) {
//         var percent = parseFloat(100 / steps) * curStep;
//         percent = percent.toFixed();
//         $(".progress-bar").css("width", percent + "%");
//     }

//     $(".submit").click(function () {
//         return false;
//     });
// })(jQuery);
