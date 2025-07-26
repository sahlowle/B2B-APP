  "use strict";
  // user change language
$('.lang-change').on('click', function() {
    var lang = $(this).find('.lang').data('short_name')
    var url = SITE_URL + '/change-language';
    $.ajax({
        url   :url,
        data:{
            _token:token,
            lang: lang,
            type: 'user'
        },
        type:"POST",
        success:function(data) {

            if (data == 1) {
                location.reload();
            }
            if (data.status == 'info') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-start',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'error',
                    title: data.message
                })
            }
        },
         error: function(xhr, desc, err) {
            return 0;
        }
    });
});

  $('.currency-change').on('click', function() {
      var multi_currency_id = $(this).find('.currency').data('currency_id');
      var url = SITE_URL + '/change-currency';
      $.ajax({
          url   :url,
          data:{
              _token:token,
              currency_id: multi_currency_id,
              type: 'user'
          },
          type:"POST",
          success:function(data) {

              if (data.status == 1) {
                  location.reload();
              }
              if (data.status == 'info') {
                  const Toast = Swal.mixin({
                      toast: true,
                      position: 'bottom-start',
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: true,
                      didOpen: (toast) => {
                          toast.addEventListener('mouseenter', Swal.stopTimer)
                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                      }
                  })
                  Toast.fire({
                      icon: 'error',
                      title: data.message
                  })
              }
          },
          error: function(xhr, desc, err) {
              return 0;
          }
      });
  });
