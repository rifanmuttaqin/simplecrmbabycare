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
      <a  href="#" type="button" class="btn btn-info" id="tambah"> TAMBAH </a>
    </div>

    <div style="width: 100%; padding-left: -10px;">
      <div class="table-responsive">
      <table id="layanan_table" class="table table-bordered data-table display nowrap" style="width:100%">
      <thead style="text-align:center;">
          <tr>
              <th style="width: 10%">Kode Layanan</th>
              <th style="width: 40%">Nama Layanan</th>
              <th style="width: 10%">Harga</th>
              <th style="width: 30%">Keterangan</th>
              <th style="width: 5%">aksi</th>
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

<div class="modal fade" id="createModal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
        <div class="modal-body">
     
          <div class="form-group">
            <label>Nama Layanan</label>
            <input type="text" class="form-control" id="nama_layanan">
          </div>

          <div class="form-group">
            <label>Harga</label>
            <input type="text" class="form-control" id="harga">
          </div>

          <div class="form-group">
            <label>Keterangan</label>
            <textarea type="text" class="form-control" id="keterangan"></textarea>
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


<!-- ---------- UPDATE MODAL ------------ -->

<div class="modal fade" id="updateModal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
        <div class="modal-body">
          
          <input type="hidden" id="id_update">

          <div class="form-group">
            <label>Nama Layanan</label>
            <input type="text" class="form-control" id="nama_layanan_update">
          </div>

          <div class="form-group">
            <label>Harga</label>
            <input type="text" class="form-control" id="harga_update">
          </div>

          <div class="form-group">
            <label>Keterangan</label>
            <textarea type="text" class="form-control" id="keterangan_update"></textarea>
          </div>

        </div>
      
        <div class="modal-footer">
          <div class="form-group">
            <button type="button" id="prosess_update" class="btn btn-info btn-default pull-left">UPDATE</button>
          </div>
        </div>       

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">

// ------- Global function --------

var token    = "{{ csrf_token() }}";

function clearAll()
{
  $('#nama_layanan').val(null);
  $('#harga').val(null);
  $('#keterangan').val(null);
}

function btnDel(idlayanan)
{
  var url   = '{{route("layanan-delete")}}';
  var token = "{{ csrf_token() }}";
  swalConfrim("Menghapus Data","Data yang telah dihapus tidak dapat untuk dikembalikan",idlayanan,url,token);
}

$(function () {

  clearAll();

  // Datatables
  table = $('#layanan_table').DataTable({
      processing: true,
      serverSide: true,
      rowReorder: {
          selector: 'td:nth-child(2)'
      },
      responsive: true,
      ajax: "{{ route('layanan') }}",
      columns: [
          {data: 'kode_layanan', name: 'kode_layanan'},
          {data: 'nama_layanan', name: 'nama_layanan'},
          {data: 'harga', name: 'harga'},
          {data: 'keterangan', name: 'keterangan'},
          {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
  });

  // Row Click event
  $('.dataTable').on('click', 'tbody tr', function() {
      
      var data = table.row(this).data();
      
      $('#id_update').val(data.id);

      $('#nama_layanan_update').val(data.nama_layanan);
      $('#harga_update').val(data.harga);
      $('#keterangan_update').val(data.keterangan);

      $('#updateModal').modal('toggle');

  })

  $( "#tambah" ).click(function() { $('#createModal').modal('toggle'); });

  // ------ CREATE -----

  $( "#prosess" ).click(function() {
    
    var param = null;
    var url   = "{{route('layanan-store')}}";
    
    param     = { 
      token : token,
      nama_layanan :$('#nama_layanan').val(), 
      harga :$('#harga').val(), 
      keterangan:$('#keterangan').val()
    };

    token    = "{{ csrf_token() }}";

    setAjaxInsert(url, param, token);

    $('#createModal').modal('toggle');

  });


  // -------- UPDATE ------------

  $( "#prosess_update" ).click(function() {
    
    var param = null;
    var url   = "{{route('layanan-update')}}";
    
    param = { 
      id:$('#id_update').val(),
      nama_layanan :$('#nama_layanan_update').val(), 
      harga :$('#harga_update').val(), 
      keterangan:$('#keterangan_update').val()
    };

    setAjaxInsert(url, param, token);

    $('#updateModal').modal('toggle');

  });

});

</script>

@endpush