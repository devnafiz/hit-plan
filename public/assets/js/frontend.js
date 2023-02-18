(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/frontend"],{

/***/ "./resources/js/bootstrap.js":
/*!***********************************!*\
  !*** ./resources/js/bootstrap.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

window.Swal = __webpack_require__(/*! sweetalert2 */ "./node_modules/sweetalert2/dist/sweetalert2.all.js");
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.Popper = __webpack_require__(/*! popper.js */ "./node_modules/popper.js/dist/esm/popper.js").default;
  window.$ = window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

  __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
} catch (e) {}

/***/ }),

/***/ "./resources/js/frontend/app.js":
/*!**************************************!*\
  !*** ./resources/js/frontend/app.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! ../bootstrap */ "./resources/js/bootstrap.js");

__webpack_require__(/*! ../plugins */ "./resources/js/plugins.js");

/***/ }),

/***/ "./resources/js/plugins.js":
/*!*********************************!*\
  !*** ./resources/js/plugins.js ***!
  \*********************************/
/***/ (() => {

/**
 * Place any jQuery/helper plugins in here.
 */
$(function () {
  /**
   * Checkbox tree for permission selecting
   */
  var permissionTree = $('.permission-tree :checkbox');
  permissionTree.on('click change', function () {
    if ($(this).is(':checked')) {
      $(this).siblings('ul').find('input[type="checkbox"]').attr('checked', true).attr('disabled', true);
    } else {
      $(this).siblings('ul').find('input[type="checkbox"]').removeAttr('checked').removeAttr('disabled');
    }
  });
  permissionTree.each(function () {
    if ($(this).is(':checked')) {
      $(this).siblings('ul').find('input[type="checkbox"]').attr('checked', true).attr('disabled', true);
    }
  });
  /**
   * Disable submit inputs in the given form
   *
   * @param form
   */

  function disableSubmitButtons(form) {
    form.find('input[type="submit"]').attr('disabled', true);
    form.find('button[type="submit"]').attr('disabled', true);
  }
  /**
   * Enable the submit inputs in a given form
   *
   * @param form
   */


  function enableSubmitButtons(form) {
    form.find('input[type="submit"]').removeAttr('disabled');
    form.find('button[type="submit"]').removeAttr('disabled');
  }
  /**
   * Disable all submit buttons once clicked
   */


  $('form').submit(function () {
    disableSubmitButtons($(this));
    return true;
  });
  /**
   * Add a confirmation to a delete button/form
   */

  $('body').on('submit', 'form[name=delete-item]', function (e) {
    var _this = this;

    e.preventDefault();
    Swal.fire({
      title: 'Are you sure you want to delete this item?',
      showCancelButton: true,
      confirmButtonText: 'Confirm Delete',
      cancelButtonText: 'Cancel',
      icon: 'warning'
    }).then(function (result) {
      if (result.value) {
        _this.submit();
      } else {
        enableSubmitButtons($(_this));
      }
    });
  }).on('submit', 'form[name=confirm-item]', function (e) {
    var _this2 = this;

    e.preventDefault();
    Swal.fire({
      title: 'Are you sure you want to do this?',
      showCancelButton: true,
      confirmButtonText: 'Continue',
      cancelButtonText: 'Cancel',
      icon: 'warning'
    }).then(function (result) {
      if (result.value) {
        _this2.submit();
      } else {
        enableSubmitButtons($(_this2));
      }
    });
  }).on('click', 'a[name=confirm-item]', function (e) {
    var _this3 = this;

    /**
     * Add an 'are you sure' pop-up to any button/link
     */
    e.preventDefault();
    Swal.fire({
      title: 'Are you sure you want to do this?',
      showCancelButton: true,
      confirmButtonText: 'Continue',
      cancelButtonText: 'Cancel',
      icon: 'info'
    }).then(function (result) {
      result.value && window.location.assign($(_this3).attr('href'));
    });
  }); // Remember tab on page load

  $('a[data-toggle="tab"], a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
    var hash = $(e.target).attr('href');
    history.pushState ? history.pushState(null, null, hash) : location.hash = hash;
  });
  var hash = window.location.hash;

  if (hash) {
    $('.nav-link[href="' + hash + '"]').tab('show');
  } // Enable tooltips everywhere


  $('[data-toggle="tooltip"]').tooltip();
});

/***/ }),

/***/ "./resources/sass/frontend/app.scss":
/*!******************************************!*\
  !*** ./resources/sass/frontend/app.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/sass/backend/app.scss":
/*!*****************************************!*\
  !*** ./resources/sass/backend/app.scss ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
0,[["./resources/js/frontend/app.js","/js/manifest","/js/vendor"],["./resources/sass/frontend/app.scss","/js/manifest","/js/vendor"],["./resources/sass/backend/app.scss","/js/manifest","/js/vendor"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvYm9vdHN0cmFwLmpzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9qcy9mcm9udGVuZC9hcHAuanMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL3BsdWdpbnMuanMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL3Nhc3MvZnJvbnRlbmQvYXBwLnNjc3MiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL3Nhc3MvYmFja2VuZC9hcHAuc2NzcyJdLCJuYW1lcyI6WyJ3aW5kb3ciLCJTd2FsIiwicmVxdWlyZSIsIlBvcHBlciIsIiQiLCJqUXVlcnkiLCJlIiwicGVybWlzc2lvblRyZWUiLCJvbiIsImlzIiwic2libGluZ3MiLCJmaW5kIiwiYXR0ciIsInJlbW92ZUF0dHIiLCJlYWNoIiwiZGlzYWJsZVN1Ym1pdEJ1dHRvbnMiLCJmb3JtIiwiZW5hYmxlU3VibWl0QnV0dG9ucyIsInN1Ym1pdCIsInByZXZlbnREZWZhdWx0IiwiZmlyZSIsInRpdGxlIiwic2hvd0NhbmNlbEJ1dHRvbiIsImNvbmZpcm1CdXR0b25UZXh0IiwiY2FuY2VsQnV0dG9uVGV4dCIsImljb24iLCJ0aGVuIiwicmVzdWx0IiwidmFsdWUiLCJsb2NhdGlvbiIsImFzc2lnbiIsImhhc2giLCJ0YXJnZXQiLCJoaXN0b3J5IiwicHVzaFN0YXRlIiwidGFiIiwidG9vbHRpcCJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7QUFDQUEsTUFBTSxDQUFDQyxJQUFQLEdBQWNDLG1CQUFPLENBQUMsdUVBQUQsQ0FBckI7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLElBQUk7QUFDQUYsUUFBTSxDQUFDRyxNQUFQLEdBQWdCRCwyRkFBaEI7QUFDQUYsUUFBTSxDQUFDSSxDQUFQLEdBQVdKLE1BQU0sQ0FBQ0ssTUFBUCxHQUFnQkgsbUJBQU8sQ0FBQyxvREFBRCxDQUFsQzs7QUFFQUEscUJBQU8sQ0FBQyxnRUFBRCxDQUFQO0FBQ0gsQ0FMRCxDQUtFLE9BQU9J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UixHQUFDLENBQUMsNkNBQUQsQ0FBRCxDQUFpREksRUFBakQsQ0FBb0QsY0FBcEQsRUFBb0UsVUFBVUYsQ0FBVixFQUFhO0FBQzdFLFFBQUl5QixJQUFJLEdBQUczQixDQUFDLENBQUNFLENBQUMsQ0FBQzBCLE1BQUgsQ0FBRCxDQUFZcEIsSUFBWixDQUFpQixNQUFqQixDQUFYO0FBQ0FxQixXQUFPLENBQUNDLFNBQVIsR0FBb0JELE9BQU8sQ0FBQ0MsU0FBUixDQUFrQixJQUFsQixFQUF3QixJQUF4QixFQUE4QkgsSUFBOUIsQ0FBcEIsR0FBMERGLFFBQVEsQ0FBQ0UsSUFBVCxHQUFnQkEsSUFBMUU7QUFDSCxHQUhEO0FBS0EsTUFBSUEsSUFBSSxHQUFHL0IsTUFBTSxDQUFDNkIsUUFBUCxDQUFnQkUsSUFBM0I7O0FBQ0EsTUFBSUEsSUFBSixFQUFVO0FBQ04zQixLQUFDLENBQUMscUJBQW1CMkIsSUFBbkIsR0FBd0IsSUFBekIsQ0FBRCxDQUFnQ0ksR0FBaEMsQ0FBb0MsTUFBcEM7QUFDSCxHQS9HUyxDQWlIVjs7O0FBQ0EvQixHQUFDLENBQUMseUJBQUQsQ0FBRCxDQUE2QmdDLE9BQTdCO0FBQ0gsQ0FuSEEsQ0FBRCxDOzs7Ozs7Ozs7Ozs7QUNIQTs7Ozs7Ozs7Ozs7OztBQ0FBIiwiZmlsZSI6Ii9qcy9mcm9udGVuZC5qcyIsInNvdXJjZXNDb250ZW50IjpbIlxud2luZG93LlN3YWwgPSByZXF1aXJlKCdzd2VldGFsZXJ0MicpO1xuXG4vKipcbiAqIFdlJ2xsIGxvYWQgalF1ZXJ5IGFuZCB0aGUgQm9vdHN0cmFwIGpRdWVyeSBwbHVnaW4gd2hpY2ggcHJvdmlkZXMgc3VwcG9ydFxuICogZm9yIEphdmFTY3JpcHQgYmFzZWQgQm9vdHN0cmFwIGZlYXR1cmVzIHN1Y2ggYXMgbW9kYWxzIGFuZCB0YWJzLiBUaGlzXG4gKiBjb2RlIG1heSBiZSBtb2RpZmllZCB0byBmaXQgdGhlIHNwZWNpZmljIG5lZWRzIG9mIHlvdXIgYXBwbGljYXRpb24uXG4gKi9cblxudHJ5IHtcbiAgICB3aW5kb3cuUG9wcGVyID0gcmVxdWlyZSgncG9wcGVyLmpzJykuZGVmYXVsdDtcbiAgICB3aW5kb3cuJCA9IHdpbmRvdy5qUXVlcnkgPSByZXF1aXJlKCdqcXVlcnknKTtcblxuICAgIHJlcXVpcmUoJ2Jvb3RzdHJhcCcpO1xufSBjYXRjaCAoZSkge31cbiIsIlxuXG5yZXF1aXJlKCcuLi9ib290c3RyYXAnKTtcbnJlcXVpcmUoJy4uL3BsdWdpbnMnKTtcbiIsIi8qKlxuICogUGxhY2UgYW55IGpRdWVyeS9oZWxwZXIgcGx1Z2lucyBpbiBoZXJlLlxuICovXG4kKGZ1bmN0aW9uICgpIHtcbiAgICAvKipcbiAgICAgKiBDaGVja2JveCB0cmVlIGZvciBwZXJtaXNzaW9uIHNlbGVjdGluZ1xuICAgICAqL1xuICAgIGxldCBwZXJtaXNzaW9uVHJlZSA9ICQoJy5wZXJtaXNzaW9uLXRyZWUgOmNoZWNrYm94Jyk7XG5cbiAgICBwZXJtaXNzaW9uVHJlZS5vbignY2xpY2sgY2hhbmdlJywgZnVuY3Rpb24gKCl7XG4gICAgICAgIGlmKCQodGhpcykuaXMoJzpjaGVja2VkJykpIHtcbiAgICAgICAgICAgICQodGhpcykuc2libGluZ3MoJ3VsJykuZmluZCgnaW5wdXRbdHlwZT1cImNoZWNrYm94XCJdJykuYXR0cignY2hlY2tlZCcsIHRydWUpLmF0dHIoJ2Rpc2FibGVkJywgdHJ1ZSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKHRoaXMpLnNpYmxpbmdzKCd1bCcpLmZpbmQoJ2lucHV0W3R5cGU9XCJjaGVja2JveFwiXScpLnJlbW92ZUF0dHIoJ2NoZWNrZWQnKS5yZW1vdmVBdHRyKCdkaXNhYmxlZCcpO1xuICAgICAgICB9XG4gICAgfSk7XG5cbiAgICBwZXJtaXNzaW9uVHJlZS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgaWYoJCh0aGlzKS5pcygnOmNoZWNrZWQnKSkge1xuICAgICAgICAgICAgJCh0aGlzKS5zaWJsaW5ncygndWwnKS5maW5kKCdpbnB1dFt0eXBlPVwiY2hlY2tib3hcIl0nKS5hdHRyKCdjaGVja2VkJywgdHJ1ZSkuYXR0cignZGlzYWJsZWQnLCB0cnVlKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG4gICAgLyoqXG4gICAgICogRGlzYWJsZSBzdWJtaXQgaW5wdXRzIGluIHRoZSBnaXZlbiBmb3JtXG4gICAgICpcbiAgICAgKiBAcGFyYW0gZm9ybVxuICAgICAqL1xuICAgIGZ1bmN0aW9uIGRpc2FibGVTdWJtaXRCdXR0b25zKGZvcm0pIHtcbiAgICAgICAgZm9ybS5maW5kKCdpbnB1dFt0eXBlPVwic3VibWl0XCJdJykuYXR0cignZGlzYWJsZWQnLCB0cnVlKTtcbiAgICAgICAgZm9ybS5maW5kKCdidXR0b25bdHlwZT1cInN1Ym1pdFwiXScpLmF0dHIoJ2Rpc2FibGVkJywgdHJ1ZSk7XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogRW5hYmxlIHRoZSBzdWJtaXQgaW5wdXRzIGluIGEgZ2l2ZW4gZm9ybVxuICAgICAqXG4gICAgICogQHBhcmFtIGZvcm1cbiAgICAgKi9cbiAgICBmdW5jdGlvbiBlbmFibGVTdWJtaXRCdXR0b25zKGZvcm0pIHtcbiAgICAgICAgZm9ybS5maW5kKCdpbnB1dFt0eXBlPVwic3VibWl0XCJdJykucmVtb3ZlQXR0cignZGlzYWJsZWQnKTtcbiAgICAgICAgZm9ybS5maW5kKCdidXR0b25bdHlwZT1cInN1Ym1pdFwiXScpLnJlbW92ZUF0dHIoJ2Rpc2FibGVkJyk7XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogRGlzYWJsZSBhbGwgc3VibWl0IGJ1dHRvbnMgb25jZSBjbGlja2VkXG4gICAgICovXG4gICAgJCgnZm9ybScpLnN1Ym1pdChmdW5jdGlvbiAoKSB7XG4gICAgICAgIGRpc2FibGVTdWJtaXRCdXR0b25zKCQodGhpcykpO1xuICAgICAgICByZXR1cm4gdHJ1ZTtcbiAgICB9KTtcblxuICAgIC8qKlxuICAgICAqIEFkZCBhIGNvbmZpcm1hdGlvbiB0byBhIGRlbGV0ZSBidXR0b24vZm9ybVxuICAgICAqL1xuICAgICQoJ2JvZHknKS5vbignc3VibWl0JywgJ2Zvcm1bbmFtZT1kZWxldGUtaXRlbV0nLCBmdW5jdGlvbihlKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcblxuICAgICAgICBTd2FsLmZpcmUoe1xuICAgICAgICAgICAgdGl0bGU6ICdBcmUgeW91IHN1cmUgeW91IHdhbnQgdG8gZGVsZXRlIHRoaXMgaXRlbT8nLFxuICAgICAgICAgICAgc2hvd0NhbmNlbEJ1dHRvbjogdHJ1ZSxcbiAgICAgICAgICAgIGNvbmZpcm1CdXR0b25UZXh0OiAnQ29uZmlybSBEZWxldGUnLFxuICAgICAgICAgICAgY2FuY2VsQnV0dG9uVGV4dDogJ0NhbmNlbCcsXG4gICAgICAgICAgICBpY29uOiAnd2FybmluZydcbiAgICAgICAgfSkudGhlbigocmVzdWx0KSA9PiB7XG4gICAgICAgICAgICBpZiAocmVzdWx0LnZhbHVlKSB7XG4gICAgICAgICAgICAgICAgdGhpcy5zdWJtaXQoKVxuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBlbmFibGVTdWJtaXRCdXR0b25zKCQodGhpcykpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9KVxuICAgICAgICAub24oJ3N1Ym1pdCcsICdmb3JtW25hbWU9Y29uZmlybS1pdGVtXScsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgICAgIFN3YWwuZmlyZSh7XG4gICAgICAgICAgICAgICAgdGl0bGU6ICdBcmUgeW91IHN1cmUgeW91IHdhbnQgdG8gZG8gdGhpcz8nLFxuICAgICAgICAgICAgICAgIHNob3dDYW5jZWxCdXR0b246IHRydWUsXG4gICAgICAgICAgICAgICAgY29uZmlybUJ1dHRvblRleHQ6ICdDb250aW51ZScsXG4gICAgICAgICAgICAgICAgY2FuY2VsQnV0dG9uVGV4dDogJ0NhbmNlbCcsXG4gICAgICAgICAgICAgICAgaWNvbjogJ3dhcm5pbmcnXG4gICAgICAgICAgICB9KS50aGVuKChyZXN1bHQpID0+IHtcbiAgICAgICAgICAgICAgICBpZiAocmVzdWx0LnZhbHVlKSB7XG4gICAgICAgICAgICAgICAgICAgIHRoaXMuc3VibWl0KClcbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICBlbmFibGVTdWJtaXRCdXR0b25zKCQodGhpcykpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9KVxuICAgICAgICAub24oJ2NsaWNrJywgJ2FbbmFtZT1jb25maXJtLWl0ZW1dJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgLyoqXG4gICAgICAgICAqIEFkZCBhbiAnYXJlIHlvdSBzdXJlJyBwb3AtdXAgdG8gYW55IGJ1dHRvbi9saW5rXG4gICAgICAgICAqL1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgU3dhbC5maXJlKHtcbiAgICAgICAgICAgIHRpdGxlOiAnQXJlIHlvdSBzdXJlIHlvdSB3YW50IHRvIGRvIHRoaXM/JyxcbiAgICAgICAgICAgIHNob3dDYW5jZWxCdXR0b246IHRydWUsXG4gICAgICAgICAgICBjb25maXJtQnV0dG9uVGV4dDogJ0NvbnRpbnVlJyxcbiAgICAgICAgICAgIGNhbmNlbEJ1dHRvblRleHQ6ICdDYW5jZWwnLFxuICAgICAgICAgICAgaWNvbjogJ2luZm8nLFxuICAgICAgICB9KS50aGVuKChyZXN1bHQpID0+IHtcbiAgICAgICAgICAgIHJlc3VsdC52YWx1ZSAmJiB3aW5kb3cubG9jYXRpb24uYXNzaWduKCQodGhpcykuYXR0cignaHJlZicpKTtcbiAgICAgICAgfSk7XG4gICAgfSk7XG5cbiAgICAvLyBSZW1lbWJlciB0YWIgb24gcGFnZSBsb2FkXG4gICAgJCgnYVtkYXRhLXRvZ2dsZT1cInRhYlwiXSwgYVtkYXRhLXRvZ2dsZT1cInBpbGxcIl0nKS5vbignc2hvd24uYnMudGFiJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgbGV0IGhhc2ggPSAkKGUudGFyZ2V0KS5hdHRyKCdocmVmJyk7XG4gICAgICAgIGhpc3RvcnkucHVzaFN0YXRlID8gaGlzdG9yeS5wdXNoU3RhdGUobnVsbCwgbnVsbCwgaGFzaCkgOiBsb2NhdGlvbi5oYXNoID0gaGFzaDtcbiAgICB9KTtcblxuICAgIGxldCBoYXNoID0gd2luZG93LmxvY2F0aW9uLmhhc2g7XG4gICAgaWYgKGhhc2gpIHtcbiAgICAgICAgJCgnLm5hdi1saW5rW2hyZWY9XCInK2hhc2grJ1wiXScpLnRhYignc2hvdycpO1xuICAgIH1cblxuICAgIC8vIEVuYWJsZSB0b29sdGlwcyBldmVyeXdoZXJlXG4gICAgJCgnW2RhdGEtdG9nZ2xlPVwidG9vbHRpcFwiXScpLnRvb2x0aXAoKTtcbn0pO1xuIiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307IiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307Il0sInNvdXJjZVJvb3QiOiIifQ==