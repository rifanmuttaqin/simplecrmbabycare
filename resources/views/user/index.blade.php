@extends('master')
 
@section('title', 'Manajemen User')

@section('alert')

@if(Session::has('alert_success'))
  @component('components.alert')
        @slot('class')
            success
        @endslot
        @slot('title')
            Terimakasih
        @endslot
        @slot('message')
            {{ session('alert_success') }}
        @endslot
  @endcomponent
@elseif(Session::has('alert_error'))
  @component('components.alert')
        @slot('class')
            error
        @endslot
        @slot('title')
            Cek Kembali
        @endslot
        @slot('message')
            {{ session('alert_error') }}
        @endslot
  @endcomponent 
@endif

@endsection

@section('content')

<div class="row">
<div class="col-lg-12 col-md-12 col-12 col-sm-12">
    <div class="card">
    <div class="card-header">
        <h4>{{ $title }}</h4>
    </div>
    <div class="card-body">

    <div style="padding-bottom: 20px">
      <a  href="{{ route('create-user') }}" type="button" class="btn btn-info"> TAMBAH </a>
    </div>

    <div style="width: 100%; padding-left: -10px;">
      <div class="table-responsive">
      <table id="user_table" class="table table-bordered data-table display nowrap" style="width:100%">
      <thead style="text-align:center;">
          <tr>
              <th style="width: 10%">Nama</th>
              <th style="width: 50%">Nama Penuh</th>
              <th style="width: 30%">Tipe Akun</th>
              <th style="width: 10%">Action</th>
          </tr>
      </thead>
      <tbody>
      </tbody>
      </table>
      </div>
    </div>
        
    </div>
    </div>
</div>
</div>


@endsection

@section('modal')

<div class="modal fade" id="detailModal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
   
    <div class="form-group">
      <label>Email</label>
      <input type="text" class="form-control" value="" id="email">
    </div>

    <div class="form-group">
      <label>Nama</label>
      <input type="text" class="form-control" value="" id="nama">
    </div>

    <div class="form-group">
      <label>Nama Lengkap</label>
      <input type="text" class="form-control" value="" id="nama_penuh">
    </div>

    <div class="form-group">
      <label>Nomor HP</label>
      <input type="text" class="form-control" value="" id="nomor_hp">
    </div>
      
    <div class="form-group">
      <label for="sel1">Tipe Akun</label>
      <select class="form-control" id="tipe_akun">
        <option value="{{ User::ACCOUNT_TYPE_ADMIN }}" >Admin</option>
      </select>
    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" id="non_aktif_button">Non Aktifkan</button>
        <button type="button" id="update_data" class="btn btn-default pull-left">Update</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updatePassword" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" value="" id="nama_change_password" disabled>
          </div>

          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" value="" id="nama_penuh">
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" value="" id="password">
          </div>

          <div class="form-group">
            <label>Re Password</label>
            <input type="password" class="form-control" value="" id="password_confirmation">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="update_data_password" class="btn btn-info btn-default pull-left">Update Password</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">

var iduser;
var table;

function clearAll(){
  $('#username').val('');
  $('#tipe_akun').val('');
  $('#email').val('');
  $('#nama_lengkap').val('');
  $('#alamat').val('');
}

$(function () {
  table = $('#user_table').DataTable({
      processing: true,
      serverSide: true,
      rowReorder: {
          selector: 'td:nth-child(2)'
      },
      responsive: true,
      ajax: "{{ route('index-user') }}",
      columns: [
          {data: 'nama', name: 'nama'},
          {data: 'nama_penuh', name: 'nama_penuh'},
          {data: 'account_type', name: 'account_type'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
  });
});

function btnDel(id)
{
  iduser = id;
  
  swal({
      title: "Menon Aktifkan User",
      text: 'User yang telah dinon aktifkan tidak dapat diaktifkan kembali', 
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
        type:'POST',
        url: '{{route("delete-user")}}',
        data:{
          iduser:iduser, 
          "_token": "{{ csrf_token() }}",},
        success:function(data) {
          
          if(data.status != false)
          {
            swal(data.message, { button:false, icon: "success", timer: 1000});
          }
          else
          {
            swal(data.message, { button:false, icon: "error", timer: 1000});
          }

          table.ajax.reload();
        },
        error: function(error) {
          swal('Terjadi kegagalan sistem', { button:false, icon: "error", timer: 1000});
        }
      });      
    }
  });
}

function btnPass(id){

  $('#updatePassword').modal('toggle');

  iduser = id;

  $.ajax({
     type:'POST',
     url: '{{route("user-detail")}}',
     data:{iduser:iduser, "_token": "{{ csrf_token() }}",},
     success:function(data) {
        $('#nik_change_password').val(data.data.nik);
        $('#nama_change_password').val(data.data.nama);
     },
     error: function(error) {
      swal('Terjadi kegagalan sistem', { button:false, icon: "error", timer: 1000});
    }
  });
}


function btnUbah(id){

  $('#detailModal').modal('toggle');
  
  iduser = id;

  $.ajax({
     type:'POST',
     url: '{{route("user-detail")}}',
     data:{iduser:iduser, "_token": "{{ csrf_token() }}",},
     success:function(data) {
        $('#email').val(data.data.email);
        $('#nama_penuh').val(data.data.nama_penuh);
        $('#nama').val(data.data.nama);
        $('#nomor_hp').val(data.data.nomor_hp);
        $('#tipe_akun').val(data.data.account_type);
     }
  });

}

$( document ).ready(function() {

$( "#tipe_akun" ).change(function() {
  
});


$('#non_aktif_button').click(function() { 
      btnDel(iduser)
      $("#detailModal .close").click()
})

$('#update_data_password').click(function() {

    var password = $('#password').val();
    var password_confirmation = $('#password_confirmation').val();

    $.ajax({
      type:'POST',
      url: '{{route("update-password-user")}}',
      data:
      {
        iduser:iduser, 
        "_token": "{{ csrf_token() }}",
        password : password,
        password_confirmation : password_confirmation,
      },
      success:function(data) {

        if(data.status != false)
        {
          swal(data.message, { button:false, icon: "success", timer: 1000});
          $("#updatePassword .close").click()
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
})

$('#update_data').click(function() { 

    var email         = $('#email').val();
    var nama          = $('#nama').val();
    var nomor_hp      = $('#nomor_hp').val();
    var account_type  = $('#tipe_akun').val();
    var nama_penuh    = $('#nama_penuh').val();
    
    $.ajax({
      type:'POST',
      url: '{{route("update-user")}}',
      data:{
        iduser        : iduser, 
        "_token": "{{ csrf_token() }}",
        
        email         : email,
        nama          : nama,
        nomor_hp      : nomor_hp,
        nama_penuh    : nama_penuh,
        account_type  : account_type

      },
      success:function(data) {
        if(data.status != false)
        {
          console.log('Sucsesss');
          table.ajax.reload();
          swal(data.message, { button:false, icon: "success", timer: 1000});
          $("#detailModal .close").click();
          clearAll();
        }
        else
        {
          console.log('Errorrr');
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
})    

});

</script>

@endpush