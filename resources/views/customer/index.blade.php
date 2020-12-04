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
      <table id="customer_table" class="table table-bordered data-table display nowrap" style="width:100%">
      <thead style="text-align:center;">
          <tr>
              <th style="width: 50%">Nama</th>
              <th style="width: 10%">Telfon</th>
              <th style="width: 30%">Alamat Lengkap</th>
              <th style="width: 5%">Umur</th>
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
            <label>Tanggal Lahir</label>
            <input type="text" class="form-control" name="tgl_lahir_update" id="tgl_lahir_update">
          </div>

          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" id="nama_update">
          </div>

          <div class="form-group">
            <label>Telfon / WA</label>
            <input type="text" class="form-control" id="telfon_update">
          </div>

          <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea type="text" class="form-control" id="alamat_lengkap_update"></textarea>
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
  $('#nama').val(null);
  $('#telfon').val(null);
  $('#alamat_lengkap').val(null);
  $('#tgl_lahir').val(null);
}

function btnDel(iduser)
{
  var url   = '{{route("customer-delete")}}';
  var token = "{{ csrf_token() }}";
  swalConfrim("Menghapus Data","Data yang telah dihapus tidak dapat untuk dikembalikan",iduser,url,token);
}

$(function () {

  $('input[name="tgl_lahir"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    autoApply: true,
  });

  $('input[name="tgl_lahir_update"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    autoApply: true,
  });

  clearAll();

  // Datatables
  table = $('#customer_table').DataTable({
      processing: true,
      serverSide: true,
      rowReorder: {
          selector: 'td:nth-child(2)'
      },
      responsive: true,
      ajax: "{{ route('customer') }}",
      columns: [
          {data: 'nama', name: 'nama'},
          {data: 'alamat_lengkap', name: 'alamat_lengkap'},
          {data: 'telfon', name: 'telfon'},
          {data: 'tgl_lahir', name: 'tgl_lahir'},
          {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
  });

  // Row Click event
  $('.dataTable').on('click', 'tbody tr', function() {
      
      var data = table.row(this).data();
      
      $('#id_update').val(data.id);

      $('#nama_update').val(data.nama);
      $('#telfon_update').val(data.telfon);
      $('#alamat_lengkap_update').val(data.alamat_lengkap);
      $('#tgl_lahir_update').val(data.tgl_lahir);

      $('#updateModal').modal('toggle');

  })


  $( "#tambah" ).click(function() { $('#createModal').modal('toggle'); });

  // ------ CREATE -----

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


  // -------- UPDATE ------------

  $( "#prosess_update" ).click(function() {
    
    var param = null;
    var url   = "{{route('customer-update')}}";
    
    param = { 
      id:$('#id_update').val(),
      nama :$('#nama_update').val(), 
      alamat_lengkap :$('#alamat_lengkap_update').val(), 
      telfon:$('#telfon_update').val(),
      tgl_lahir:$('#tgl_lahir_update').val()
    };

    setAjaxInsert(url, param, token);

    $('#updateModal').modal('toggle');

  });

});

</script>

@endpush