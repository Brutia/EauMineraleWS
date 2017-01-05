@extends('layouts.app') @section('content')


<div class="container">
	<div class="alert alert-success alert-dismissible" role="alert"
		id="alert_sucess">
		<button type="button" class="close" data-dismiss="alert"
			aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succ&egrave;s!</strong> Notification envoy&eacute;e

	</div>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form role="form" class="col-md-12 go-right" method="post"
				action="{{route('push.create')}}">
				<input type="hidden" name="_method" value="PUT"> {!! csrf_field()
				!!}
				<h2>Ajout d'une notification</h2>
				<div class="form-group">
					<label for="title">Titre de la notification</label> <input
						name="title" type="text" class="form-control" required id="title">

				</div>
				<div class="form-group">

					<label for="message">Message</label>
					<textarea name=message class="form-control" required id="message"></textarea>
				</div>

				<div class="col-sm-offset-2 col-sm-10">
					<button type="button" class="btn btn-primary" id="push_send">Envoyer</button>
				</div>

				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Enregistrer</button>
				</div>

			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('js/bootstrap.min.js')}}"></script>



<script type="text/javascript">

		$(document).ready(function(){
			$('#alert_sucess').hide();
		});

		

	    $('#push_send').click(function(){
	    	$.ajax({
				  url: "{{url('admin/sendnotif')}}",
				  method: "POST",
				  data: { titre : $('#title').val() ,message: $('#message').val() },
				  headers : {
			            'X-CSRF-TOKEN' :"{{ csrf_token() }}"
			        }
				}).done(function() {

						$('#alert_sucess').show();
				});
	    });
		
</script>
@endsection