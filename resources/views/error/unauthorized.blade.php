<!-- Tambah dirubah dari submit ke AJAX -->

@extends('master')
 
@section('title', 'Halaman Error')



@section('content')

<div class="card col-sm-12">
    <div class="card-body col-sm-12">
        
        <hr>
        <div style="margin:0 auto;text-align:center">
            <h5> <p> Akses Tertolak </p></h5>
            <p> Anda tidak dapat melakukan akses halaman ini | Hubungi Administrator untuk info lebih lanjut </p>
        </div>
        <hr>
      
    </div>	
</div>
	
@endsection

@push('scripts')

<script type="text/javascript">


</script>

@endpush