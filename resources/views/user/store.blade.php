@extends('master')

@section('title', '')

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

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>Terdapat Kesalahan Pada Pengisian</li> {{ $error }}
            @endforeach
        </ul>
    </div>
    @endif

    <form method="post" action="{{ route('store-user') }}">

        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" value="" name="email">
            @if ($errors->has('username'))
                <div class="email"><p style="color: red"><span>&#42;</span> {{ $errors->first('email') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" value="" name="nama">
            @if ($errors->has('nama'))
                <div class="email"><p style="color: red"><span>&#42;</span> {{ $errors->first('nama') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" value="" name="nama_penuh">
            @if ($errors->has('nama_penuh'))
                <div class="email"><p style="color: red"><span>&#42;</span> {{ $errors->first('nama_penuh') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" class="form-control" value="" name="nomor_hp">
            @if ($errors->has('nomor_hp'))
                <div class="error"><p style="color: red"><span>&#42;</span> {{ $errors->first('nomor_hp') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label for="sel1">Tipe Akun</label>
            <select class="form-control" id="account_type" name="account_type">
            <option value="{{ User::ACCOUNT_TYPE_ADMIN }}">Admin</option>                   
            </select>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" value="" id="password" name="password">
            @if ($errors->has('password'))
                <div class="text"><p style="color: red"><span>&#42;</span> {{ $errors->first('password') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <label>Re Password</label>
            <input type="password" class="form-control" value="" name="password_confirmation" id="password_confirmation">
            @if ($errors->has('password'))
                <div class="text"><p style="color: red"><span>&#42;</span> {{ $errors->first('password') }}</p></div>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-info"> TAMBAH </button>
        </div>

    </form>
        
    </div>
    </div>
</div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">

$( document ).ready(function() {

$('#account_type').val(null);

})

</script>

@endpush