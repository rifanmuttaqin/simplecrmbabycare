@extends('master')
 
@section('title', 'Dashboard')

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

    <div class="row">

    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-chart-line"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4> Total Transaksi Bulan {{ date('M') }} </h4>
          </div>
          <div class="card-body">
           
          </div>
        </div>
      </div>
    </div>


    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-male"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4> Total Pasien Baru Pada Bulan {{ date('M') }} </h4>
          </div>
          <div class="card-body">
            
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-print"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4> Jumlah Pesanan Belum Tercetak </h4>
          </div>
          <div class="card-body">
            
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4> Pendapatan Bulan {{ date('M') }} </h4>
          </div>
          <div class="card-body">
            
          </div>
        </div>
      </div>
    </div>
       
    </div>
        
    </div>
    </div>
</div>
</div>


@endsection

@push('scripts')

@endpush