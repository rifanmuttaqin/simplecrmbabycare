<!-- Tambah dirubah dari submit ke AJAX -->

@extends('master')
 
@section('title', 'Halaman Error')



@section('content')

<div class="card col-sm-12">
    <div class="card-body col-sm-12">
        
        <hr>
        <div style="margin:0 auto;text-align:center">
            <h5> <p> {{ $title }} </p></h5>
            <p> {{ $pesan }}  </p>
        </div>
        <hr>
      
    </div>	
</div>
	
@endsection

@push('scripts')

<script type="text/javascript">


</script>

@endpush