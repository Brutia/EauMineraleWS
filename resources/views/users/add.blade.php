@extends('layouts.app') 


@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form role="form" class="col-md-12 go-right" method="post" action="{{URL::to('/admin/event')}}" >
				<input type="hidden" name="_method" value="PUT">
				{!! csrf_field() !!}
				<h2>Ajout d'un évènement</h2>
				<div class="form-group">
					<label for="title">Nom de l'évènement</label> <input 
						name="title" type="text" class="form-control" required>

				</div>
				<div class="form-group">

					<label for="description">Description</label> 
					<textarea 
						name="description" class="form-control" required></textarea>
				</div>
				<div class="form-group">

					<label for="lieu">Lieu</label>
					<input name="lieu" class="form-control" required>
				</div>
				<div class="form-group">

					<label for="start">Debut</label>
					<input name="start" class="form-control" id='datetimepicker' type="text" required>
				</div>
				<div class="form-group">

					<label for="end">Fin</label>
					<input name="end" class="form-control" id='datetimepicker1' type="text" required>
				</div>
				<div class="col-sm-offset-2 col-sm-10">
      				<button type="submit" class="btn btn-primary">Enregistrer</button>
    			</div>
				
			</form>
		</div>
	</div>
</div>


@endsection
<script type="text/javascript" src="{{URL::asset('assets/js/jquery.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/jquery-ui.css')}}" >
<script type="text/javascript" src="{{URL::asset('assets/js/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/collapse.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/transition.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery-ui.min.js')}}"></script>



<script type="text/javascript">

		

		
		$(function () {
            $('#datetimepicker').datetimepicker({
            	locale:'fr'
            });
        });
		$(function () {
	        $('#datetimepicker1').datetimepicker({
            	locale:'fr'
            });
	    });
		
</script>