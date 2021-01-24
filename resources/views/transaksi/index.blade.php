@extends('master')
 
@section('title', '{{ $title }}')

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
    <!--    <div class="card-header">
      
    </div> -->
    <div class="card-body">

    <div class="form-group row">
    <div class="col-sm-6">
        <label><small>Pasien (PX)</small></label>
        <select style="width: 100%" class="form-control select2-class" name="customer" id="customer">
        </select>
    </div>
    <div class="col-sm-6" style="padding-top: 35px">
        <button id="plus" type="button" class="btn btn-primary btn"> <i class="fas fa-plus-square"></i> </button>
    </div>
    </div>

    <hr>

    <div class="form-group row">
    <div class="col-sm-12">
        <label><small>Daftar Layanan Diambil</small></label>
        <select multiple="multiple" style="width: 100%" class="form-control select2-class" name="layanan" id="layanan">
        </select>
    </div>
    </div>

    <div class="form-group">
      <label>TOTAL HARGA</label>
      <input type="text" disabled class="form-control" id="harga">
    </div>


    <div class="form-group">
      <label>Catatan</label>
      <textarea type="text" class="form-control" id="catatan"> </textarea>
    </div>

    <div style="padding-bottom: 20px">
      <a  href="#" type="button" class="btn btn-info" id="tambah"> TAMBAH </a>
    </div>

    <hr>

    <div style="width: 100%; padding-left: -10px;">
    <div class="table-responsive">
    <table id="toko_table" class="table table-bordered data-table display nowrap" style="width:100%">
    <thead style="text-align:center;">
        <tr>
            <th style="width: 10%">PX (Pasien)</th>
            <th style="width: 50%">Layanan</th>
            <th style="width: 50%">Harga</th>
            <th style="width: 50%">Tanggal</th>
            <th style="width: 50%">Catatan</th>
        </tr>
    </thead>
    </table>
    </div>
    </div>
     
    </div>
        
    </div>
    </div>
</div>
</div>


@endsection

@section('modal')

<div class="modal fade" id="createModal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
        <div class="modal-body">
          
          <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir">
          </div>

          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" id="nama">
          </div>

          <div class="form-group">
            <label>Telfon / WA</label>
            <input type="text" class="form-control" id="telfon">
          </div>

          <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea type="text" class="form-control" id="alamat_lengkap"></textarea>
          </div>

        </div>
      
        <div class="modal-footer">
          <div class="form-group">
            <button type="button" id="prosess" class="btn btn-info btn-default pull-left">Create</button>
          </div>
        </div>       

    </div>
  </div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">

var token    = "{{ csrf_token() }}";


function clearAll()
{
  $('#nama').val(null);
  $('#telfon').val(null);
  $('#alamat_lengkap').val(null);
  $('#tgl_lahir').val(null);

  $('#customer').val(null).trigger('change');
  $('#layanan').val(null).trigger('change');
  $('#harga').val(null);
  $('#catatan').val(null);
}

/**
 * Untuk Call Ajax Get Data
 */
function getData(param, url_nya, token)
{
    $.ajax({
      type:'POST',
      url: url_nya,
      data:{"_token":token, param},
      success: setHarga,
    });
};

/**
 * Callback function untuk get response
 */
function setHarga(response)
{
  $('#harga').val('Rp.' +response+',-');
}

$(function() {

$('input[name="tgl_lahir"]').daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  autoApply: true,
});

table = $('#toko_table').DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    order: [[ 3, "desc" ]],
    rowReorder: {
        selector: 'td:nth-child(2)'
    },
    responsive: true,
    ajax: "{{route('report-transaksi')}}",
    columns: [
      {data: 'nama_customer', name: 'nama_customer'},
      {data: 'daftar_layanan', name: 'daftar_layanan'},
      {data: 'total_harga', name: 'total_harga'},
      {data: 'date', name: 'date'},
      {data: 'catatan', name: 'catatan'}
    ]
});

clearAll();

// ------ CREATE USER -----

$( "#prosess" ).click(function() {
  
  var param = null;
  var url   = "{{route('customer-store')}}";
  
  param     = { 
    nama :$('#nama').val(), 
    alamat_lengkap :$('#alamat_lengkap').val(), 
    telfon:$('#telfon').val(),
    tgl_lahir:$('#tgl_lahir').val()
  };

  setAjaxInsert(url, param, token);

  $('#createModal').modal('toggle');

});

$('#harga').val(null);

$( "#plus" ).click(function() { $('#createModal').modal('toggle'); });

$('#customer').select2({
    allowClear: true,
    placeholder: "Pilih PX",
    ajax: {
      url: '{{route("list-customer")}}',
      type: "POST",
      dataType: 'json',
          data: function(params) {
              return {
              "_token": "{{ csrf_token() }}",
              search: params.term
              }
          },
          processResults: function (data, page) {
              return {
                results: data
              };
          }
    }
});

$('#layanan').select2({
    allowClear: true,
    placeholder: "Pilih Layanan",
    ajax: {
      url: '{{route("list-layanan")}}',
      type: "POST",
      dataType: 'json',
          data: function(params) {
              return {
              "_token": "{{ csrf_token() }}",
              search: params.term
              }
          },
          processResults: function (data, page) {
              return {
                results: data
              };
          }
    }
});

// ----- Display Harga -----------

$('#layanan').on('change', function (e) {

  var param = $('#layanan').val();
  var url   = "{{route('layanan-get-harga')}}";
  
  getData(param,url,token);

});


$( "#tambah" ).click(function() {
  
  var param = null;
  var url   = "{{route('transaksi-store')}}";
  
  param     = { 
    customer_id :$('#customer').val(), 
    layanan :$('#layanan').val(), 
    catatan:$('#catatan').val(),
  };

  setAjaxInsert(url, param, token);

});

})

</script>

@endpush