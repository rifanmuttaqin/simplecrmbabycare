<!-- Update Gambar Belum Selesai Clear File Masih Trouble-->

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

			<div class="card col-sm-12">
				<div class="card-body col-sm-12">

					<form  method="post" action="{{ route('update-profile') }}" enctype="multipart/form-data">

					@csrf

          <!-- Hidden Form -->
          <input type="hidden" name ="user_id" id="user_id"  value="{{ $data_user->id }}">
          
	       <div class="form-group">
	       <label>Nama</label>
         <input type="text" class="form-control form-control-user" name ="nama" id="nama" placeholder="Nama" value="{{ $data_user->nama }}">
					@if ($errors->has('nama'))
					    <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama') }}</p></div>
					@endif
	        </div>

         <div class="form-group">
         <label>Nama Lengkap</label>
         <input type="text" class="form-control form-control-user" name ="nama_penuh" id="nama_lengkap" placeholder="Nama Lengkap" value="{{ $data_user->nama_penuh }}">
          @if ($errors->has('nama_penuh'))
              <div><p style="color: red"><span>&#42;</span> {{ $errors->first('nama_penuh') }}</p></div>
          @endif
          </div>


          <div class="form-group">
          <label>Email</label>
          <input type="Emailail" class="form-control form-control-user" name ="email" id="" placeholder="Email" value="{{ $data_user->email }}">
          @if ($errors->has('email'))
          <div><p style="color: red"><span>&#42;</span> {{ $errors->first('email') }}</p></div>
          @endif
          </div>

					<div class="form-group" style="padding-top: 20px">
						<button type="submit" class="btn btn-info"> UPDATE </button>
						<button type="button" id="change_pass" class="btn btn-info pull-right"> UBAH PASSWORD </button>
					</div>

				</div>	
			</div>

			<!-- Profile Picture  -->

			<div class="card col-sm-12">
				<div style="text-align: center; padding-top: 20px">
					<img src="<?= $data_user->profile_picture != null ? URL::to('/').'/storage/profile_picture/'.$data_user->profile_picture : URL::to('/layout/assets/img/no_logo.png') ?>" style="width:200px;height:200px;" class="img-thumbnail center-cropped" id="profile_pic">
				</div>

				<div style="text-align: center; padding-top: 10px">

				<!-- Delete Button -->
								
				<div id="trash" style="<?= $data_user->profile_picture != null ? '' : 'display: none' ?>;">
					<button type="button" class="btn btn-info" id="delete_image">
						<i class="fas fa-trash"></i>
					</button>
				</div>

				<!-- Upload Form  -->
				<div id="upload" style="<?= $data_user->profile_picture != null ? 'display: none' : '' ?>;">
					<input type="file" name="file" id="file" class="inputfile" accept="image/x-png,image/gif,image/jpeg"/>
					<label for="file"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload Foto</label>
					<p> Gambar Max. 2 MB </p>

					</form>				
				</div>

				</div>
			</div>

@endsection

@section('modal')

<div class="modal fade" id="passwordModal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="modal-title"></p>
      </div>
      <div class="modal-body">
        
        <div class="form-group col-md-12">
          <label>Password Lama</label>
          <input type="password" class="form-control" value="" id="old_password" name="old_password">
        </div>

        <div class="form-group col-md-12">
          <label>Password</label>
          <input type="password" class="form-control" value="" id="password" name="password">
        </div>

        <div class="form-group col-md-12">
          <label>Re Password</label>
          <input type="password" class="form-control" value="" id="password_confirmation" name="password_confirmation">
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" id="update_password" class="btn btn-info pull-left">Update</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">

$( document ).ready(function() {

	clearFile();

	$('#change_pass').click(function() { 
    	$('#passwordModal').modal('toggle');
  	})

	$("#file").change(function() {
    
	    var size = this.files[0].size;
	  
	    if(size >= 2000587)
	    {
	      swal('Ukuran file maksimal 2 MB', { button:false, icon: "error", timer: 1000});
	      return false;
	    }

	    readURL(this);

  	});

	$('#delete_image').click(function() { 

    swal({
      title: "Apakah anda yakin ingin menghapus foto ?",
      text: 'Foto akan hilang dan anda perlu melakukan upload ulang', 
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
        $.ajax({
          type:'POST',
          url: '{{route("deleteimage-profile")}}',
          data:
          {
            "_token": "{{ csrf_token() }}",
            user_id : $('#user_id').val(),
          },
          success:function(data) {
            if(data.status != false)
            {
              swal(data.message, { button:false, icon: "success", timer: 1000});
              clearFile();   
              showUploadImage();
            }
            else
            {
              swal(data.message, { button:false, icon: "error", timer: 1000});
            }
          },
          error: function(error) {
            var err = eval("(" + error.responseText + ")");
            var array_1 = $.map(err, function(value, index) {
                return [value];
            });
            var array_2 = $.map(array_1, function(value, index) {
                return [value];
            });
            var message = JSON.stringify(array_2);
            swal(message, { button:false, icon: "error", timer: 1000});
          }
      });
    }
  });
	});

	$('#update_password').click(function() { 

    var old_password = $('#old_password').val();
    var password = $('#password').val();
    var password_confirmation = $('#password_confirmation').val();

    $.ajax({
        type:'POST',
        url: base_url + '/profile/update-password',
        data:
        {
          "_token": "{{ csrf_token() }}",
          password : password,
          password_confirmation : password_confirmation,
          old_password : old_password
        },
        success:function(data) {
          if(data.status != false)
          {
            swal(data.message, { button:false, icon: "success", timer: 1000});
            $("#passwordModal .close").click()
          }
          else
          {
            swal(data.message, { button:false, icon: "error", timer: 1000});
          }
        },
        error: function(error) {
          var err = eval("(" + error.responseText + ")");
          var array_1 = $.map(err, function(value, index) {
              return [value];
          });
          var array_2 = $.map(array_1, function(value, index) {
              return [value];
          });
          var message = JSON.stringify(array_2);
          swal(message, { button:false, icon: "error", timer: 1000});
        }
    });
  })

});

function showUploadImage()
{
    $('#profile_pic').attr('src', '{{URL::to('/layout/assets/img/no_logo.png')}}');
    $('#upload').show();
    $('#trash').hide();
}

function showTrashImage()
{
	$('#profile_pic').attr('src', '{{URL::to('/layout/assets/img/no_logo.png')}}');
	$('#upload').hide();
    $('#trash').show();
}

function readURL(input) {
  
  showTrashImage();

  if (input.files && input.files[0]) {

    var reader = new FileReader();
    reader.onload = function(e) {
      $('#profile_pic').attr('src', e.target.result);
    }
  
    reader.readAsDataURL(input.files[0]);
  }

}

// Clear file sebelum diproses
function clearFile()
{
	$('#file').val('');
}

</script>

@endpush

