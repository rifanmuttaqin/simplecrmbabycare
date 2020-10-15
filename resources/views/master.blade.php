<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  @yield('meta')
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ isset($title) ? $title : 'Halaman' }}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
 
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ URL::to('/layout') }}/assets/css/style.css">
  <link rel="stylesheet" href="{{ URL::to('/layout') }}/assets/css/components.css">
  <link rel="stylesheet" href="{{ URL::to('/layout') }}/assets/css/custom.css">

  <!-- Sweat Alert -->
  <script src="<?= URL::to('/'); ?>/layout/assets/js/sweetalert.min.js"></script>



  <!-- DataTable -->
  <link rel="stylesheet" type="text/css" href="<?= URL::to('/'); ?>/layout/assets/css/dataTables.css">
  <script type="text/javascript" charset="utf8" src="<?= URL::to('/'); ?>/layout/assets/js/dataTables.js" defer></script>


  <!-- DateRangePicker -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


</head>

@yield('modal')

<body>
  <div id="app">
    <div class="main-wrapper">
        
        @include('include.header')

    <div class="main-sidebar">
        @include('include.sidebar')
    </div>

    <!-- Main Content -->
    <div class="main-content">
    <section class="section">
        
    <div class="section-header">
        <h1>{{ isset($title) ? $title : 'Halaman' }}</h1>
    </div>

    <div class="col-md-12" style="padding-left: 0px">

    @yield('alert')

    </div>
    
    @yield('content')

    </section>
    </div>
      
    <footer class="main-footer">
    @include('include.footer')
    </footer>

    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ URL::to('/layout') }}/assets/js/stisla.js"></script>

  <link rel="shortcut icon" href="{{ URL::to('/').'/layout/assets/img/bps_logo.ico' }}">

  <!-- Highchart -->
  <script src="<?= URL::to('/'); ?>/layout/assets/js/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>


  <!-- Select Select-->
  <link href="<?= URL::to('/'); ?>/layout/assets/css/select2.min.css" rel="stylesheet" />
  <script src="<?= URL::to('/'); ?>/layout/assets/js/select2.min.js"></script>

  <!-- JS Libraies -->

  <!-- Date Range JS -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


  <!-- Template JS File -->
  <script src="{{ URL::to('/layout') }}/assets/js/scripts.js"></script>
  <script src="{{ URL::to('/layout') }}/assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script src="{{ URL::to('/layout') }}/assets/js/page/index-0.js"></script>
</body>
</html>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Apakah anda yakin ingin meninggalkan sistem ?</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="{{ url('/auth/logout') }}">Logout</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

// Global Ajax Call

function ajaxCall(url_post,param)
{
  $.ajax({
      type:'POST',
      url: url_post,
      data: param,
      success:function(data) 
      {
          if(data.status)
          {
              return true;
          }
      }
  });
}

</script>

@stack('scripts')
