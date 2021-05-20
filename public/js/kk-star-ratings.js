"use strict";

// (function (fn) {
//   if (document.readyState != 'loading'){
//     return fn();
//   }

//   document.addEventListener('DOMContentLoaded', fn);
// })(function kkStarRatings() {
//   console.log('ready!');

//   function onClick(e) {
//     e.preventDefault();
//     var $el = e.currentTarget;
//     console.log($el);
//     //
//   }

//   var $els = document.querySelectorAll('.kk-star-ratings');
//   for (var i = 0; i < $els.length; i++) {
//     var $el = $els[i];
//     console.log($el);
//     var $stars = document.querySelectorAll('[data-star]', $el);
//     for (var j = 0; j < $stars.length; j++) {
//       var $star = $stars[j];
//       console.log($star);
//       $star.addEventListener('click', onClick);
//     }
//   }
// });

jQuery(document).ready(function ($) {
  function apply ($el, options) {
    var options = options || { isBusy: false };

    function ajax(data, successCallback, errorCallback)
    {
      if (options.isBusy || $el.hasClass('kksr-disabled')) {
        return;
      }

      options.isBusy = true;

      $.ajax({
        type: 'POST',
        url: kk_star_ratings.endpoint,
        data: Object.assign({
          nonce: kk_star_ratings.nonce,
          action: kk_star_ratings.action
        }, data),
        error: errorCallback,
        success: successCallback,
        complete: function () {
          options.isBusy = false;
        }
      });
    }

    function onClick(e) {
      var $star = $(this);

      // var payload = {
      //   id: $el.data('id'),
      //   slug: $el.data('slug'),
      //   score: $star.data('star'),
      //   best: $('[data-star]', $el).length
      // };

      ajax({
        rating: $star.data('star'),
        payload: $el.data('payload')
      }, function (response, status, xhr) {
        var $newEl = $(response);
        $newEl.addClass($el.attr('class'));
        $el.replaceWith($newEl);
        destroy();
        apply($newEl, options);
      }, function (xhr, status, err) {
        if (xhr.responseJSON && xhr.responseJSON.error) {
          console.error(xhr.responseJSON.error);
        }
      });
    }

    function destroy() {
      $('[data-star]', $el).each(function () {
        $(this).off('click', onClick);
      });

      $el.remove();
    }

    $('[data-star]', $el).each(function () {
      $(this).on('click', onClick);
    });
  }

  $('.kk-star-ratings').each(function () {
    apply($(this));
  });
});
