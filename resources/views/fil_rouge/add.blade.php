@extends('layouts.app') @section('content')


<div class="container">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form role="form" class="col-md-12 go-right" method="post"
				action="{{route('fil_rouge.store')}}">
				 {!! csrf_field() !!}
				<h2>Ajout d'un fil rouge</h2>
				<div class="form-group">
					<label for="nom">Nom du fil rouge</label> <input
						name="nom" type="text" class="form-control" required id="nom">

				</div>
				<div class="form-group">
					<label for="nom">Num&eacute;ro du fil rouge</label> <input
						name="numero" type="text" class="form-control" required id="numero">

				</div>
				

				<div class="col-sm-4">
					<button type="submit" class="btn btn-primary">Enregistrer</button>
				</div>
				
				<div class="col-sm-4">
					<a class="btn btn-primary" href="{{route('fil_rouge.index')}}">Retour</a>
				</div>

			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('js/bootstrap.min.js')}}"></script>



<script type="text/javascript">


		

	    
		
</script>
@endsection
