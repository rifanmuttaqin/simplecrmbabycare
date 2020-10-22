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

    <div class="form-group">
      <label>Kode Transaksi</label>
      <input disabled type="text" class="form-control" id="kode_transaksi">
    </div>

    <div class="form-group row">
    <div class="col-sm-12">
        <label><small>Pelanggan</small></label>
        <select style="width: 100%" class="form-control select2-class" name="customer" id="customer">
        </select>
    </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-12">
        <label><small>Layanan</small></label>
        <select style="width: 100%" class="form-control select2-class" name="layanan" id="layanan">
        </select>
    </div>
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

$(function() {

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

})

</script>

@endpush