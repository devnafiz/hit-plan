(function ($) {

  var input = document.querySelector("#phone_number");
  var instance = window.intlTelInput(input, {
    allowDropdown: false,
    autoHideDialCode: true,
    autoPlaceholder: "01810011166",
    formatOnDisplay: true,
    nationalMode: true,
    onlyCountries: ['bd'],
    separateDialCode: true,
    utilsScript: "./assets/plugins/intl-tel-input/js/utils.js",
  });
  // instance.setNumber("01810011166");

  $(document).on("change", "#phone_number", function () {
    // var extension = instance.getExtension();
    // var numberType = instance.getNumberType();
    // var countryData = instance.getSelectedCountryData();
    var intlNumber = instance.getNumber();
    var isValid = instance.isValidNumber();
    intlNumber = _.replace(intlNumber, '+88', '');
    var error_msg = $(".phone_error_msg");
    var phone = $("#phone");
    if (isValid) {
      $(this).val(intlNumber);
      phone.val(intlNumber);
      error_msg.addClass('d-none');
    } else {
      phone.val('');
      error_msg.removeClass('d-none');
      error_msg.text('Phone number is not valid');
    }
  });

})(jQuery);