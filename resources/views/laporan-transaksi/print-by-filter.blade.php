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

    <div class="form-group row">
      <div class="col-sm-12">
      <label><small>Periode Transaki</small></label>
      <input type="text" class="form-control" name="dates" id="dates">
      </div>
    </div>

    <div class="form-group">
    <label>PX (Pasien)</label>
      <select style="width: 100%" class="form-control form-control-user select2-class" name="customer" id="customer">
      </select>
    </div>

    <div class="form-group">
      <button type="button" class="btn btn-info" id="previewData"> Preview List </button>
      <button type="submit" class="btn btn-info" id="cetakData"> <i class="fas fa-print"></i> PDF </button>
    </div>

    <!-- TABLE RESULT -->
    
    <div id="table_result">
        <table class="table table-bordered data-table display nowrap" style="width:100%">
        <thead style="text-align:center;">
            <tr>
                <th>Nama Customer</th>
                <th>Layanan Diambil</th>
                <th>Ditangani Oleh</th>
                <th>Total Bayar</th>
                <th>Tanggal</th>
                <th>Catatan</th>
            </tr>
        </thead>
         <tfoot>
          <tr>
              <th colspan="3" style="text-align:right">Total:</th>
              <th colspan="3"></th>
          </tr>
      </tfoot>
        </table>
    </div>
            
    </div>
    </div>
</div>
</div>


@endsection

@push('scripts')
<script type="text/javascript">

$(function () {

  $('#table_result').hide();

  $('input[name="dates"]').daterangepicker();

  // PX
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

  $('#cetakData').click(function(){
    var url = '{{route("cetak-laporan")}}'; 
    window.location.replace(url);
  });

  $('#previewData').click(function() {

    var customer = $('#customer').select2('data');

    if(customer.length == 1)
    {
      customer = customer[0].text;
    }
    else
    {
      customer = null;
    }

    var param = 
    {
        dates       : $('#dates').val(),
        customer    : customer,
        "_token": "{{ csrf_token() }}",
    };

    table = $('.data-table').DataTable({

        ajax: 
        {
            "url": '{{route("preview-print")}}',
            "type": "POST",
            data: param,
            dataSrc: function ( json ) 
            {
                $('#table_result').show();
                return json.data;
            }     
        },

        destroy: true,
        responsive: true,
        searching: false,
        serverSide: true,
        columns: [
            {data: 'nama_customer', name: 'nama_customer'},
            {data: 'daftar_layanan', name: 'daftar_layanan'},
            {data: 'nama_terapis', name: 'nama_terapis'},
            {data: 'total_harga', name: 'total_harga'},
            {data: 'date', name: 'date'},
            {data: 'catatan', name: 'catatan'},
        ],

        // Footer Callback
        "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;
   
              // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
              };
   
              // Total over all pages
              total = api
                  .column( 3 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
   
              // Total over this page
              pageTotal = api
                  .column( 3, { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
   
              // Update footer
              $( api.column( 3 ).footer() ).html(
                ' (Keseluruhan Rp '+ total +')'
              );
          }

    });
    
  });


});

</script>

@endpush