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
    <div class="card-header">
        <h4>{{ $title }}</h4>
    </div>
    <div class="card-body">

    <div style="padding-bottom: 20px">
      <a  href="{{route('report-print')}}" type="button" class="btn btn-info" id="cetak"> <i class="fas fa-print"></i> Cetak </a>
    </div>

    <div style="width: 100%; padding-left: -10px;">
      <div class="table-responsive">
      <table id="toko_table" class="table table-bordered data-table display nowrap" style="width:100%">
      <thead style="text-align:center;">
          <tr>
              <th style="width: 10%">PX (Pasien)</th>
              <th style="width: 50%">Layanan</th>
              <th style="width: 50%">Harga</th>
              <th style="width: 50%">WA Pasien</th>
              <th style="width: 50%">Ditangani Oleh</th>
              <th style="width: 50%">Tanggal</th>
              <th style="width: 50%">Catatan</th>
              <th style="width: 30%">Aksi</th>
          </tr>
      </thead>
    
      </table>
      </div>
    </div>
        
    </div>
    </div>
</div>
</div>


@endsection

@push('scripts')
<script type="text/javascript">


$(function () {
  table = $('#toko_table').DataTable({
      processing: true,
      serverSide: true,
      order: [[ 5, "desc" ]],
      rowReorder: {
          selector: 'td:nth-child(2)'
      },
      responsive: true,
      ajax: "#",
      columns: [
        {data: 'nama_customer', name: 'nama_customer'},
        {data: 'daftar_layanan', name: 'daftar_layanan'},
        {data: 'total_harga', name: 'total_harga'},
        {data: 'wa_customer', name: 'wa_customer'},
        {data: 'nama_terapis', name: 'nama_terapis'},
        {data: 'date', name: 'date'},
        {data: 'catatan', name: 'catatan'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ]

  });
});

</script>

@endpush