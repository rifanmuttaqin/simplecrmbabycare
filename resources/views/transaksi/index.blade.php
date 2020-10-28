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
    <div class="col-sm-12">
        <label><small>Pelanggan</small></label>
        <select style="width: 100%" class="form-control select2-class" name="customer" id="customer">
        </select>
    </div>
    </div>

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
     
    </div>
        
    </div>
    </div>
</div>
</div>


@endsection

@section('modal')

@endsection

@push('scripts')

<script type="text/javascript">

var token    = "{{ csrf_token() }}";

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

$('#harga').val(null);

$('#customer').select2({
    allowClear: true,
    placeholder: "Pilih Pelanggan",
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
    layanan_id :$('#layanan').val(), 
    catatan:$('#catatan').val(),
  };

  setAjaxInsert(url, param, token);

  $('#createModal').modal('toggle');

});

})

</script>

@endpush