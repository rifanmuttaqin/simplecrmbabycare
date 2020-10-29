/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

/**
 * Untuk Swal Konfirmasi
 */
function swalConfrim(pesan_title,pesan_body,dataid,url,token)
{
  swal({
    title: pesan_title,
    text: pesan_body, 
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) { setAjaxInsert(url,dataid,token); $('.modal').modal('hide'); }
  });
}


/**
 * Untuk Call Ajax
 */
function setAjaxInsert(url_nya,param,token)
{
  $.ajax({
      type:'POST',
      url: url_nya,
      data:{"_token":token, param},
      success:function(data) {
        if(data.status != false)
        {
          swal(data.message, { button:false, icon: "success", timer: 1000});
          clearAll();
          table.ajax.reload();
        }
        else
        {
          swal(data.message, { button:false, icon: "error", timer: 1000});
        }
      },
      error: function(error) {
        var err = eval("(" + error.responseText + ")");
        var array_1 = $.map(err, function(value, index) {
            return [value];
        });
        var array_2 = $.map(array_1, function(value, index) {
            return [value];
        });
        var message = JSON.stringify(array_2);
        swal(message, { button:false, icon: "error", timer: 1000});
      }
    });
}