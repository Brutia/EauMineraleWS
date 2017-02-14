@extends('layouts.app') @section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Eau Min&eacute;rale</div>

				<div class="panel-body">
					<form class="form-horizontal">
						<fieldset>

							<!-- Form Name -->
							<legend>Commander</legend>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="textinput">Nom et pr&eacute;nom</label>
								<div class="col-md-4">
									<input id="name" name="name" type="text"
										placeholder="" class="form-control input-md"> 
								</div>
							</div>

							<!-- Select Basic -->
							<div class="form-group">
								<label class="col-md-4 control-label" for="selectbasic">Choix du fil rouge</label>
								<div class="col-md-4">
									<select id="fil_rouge" name="fil_rouge"
										class="form-control">
										@foreach($fil_rouges as $fil_rouge)
											<option value="{{$fil_rouge->id}}">{{$fil_rouge->nom}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="textinput">Lieu</label>
								<div class="col-md-4">
									<input id="lieu" name="lieu" type="text"
										placeholder="" class="form-control input-md"> 
								</div>
							</div>
							
							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="textinput">Combien?</label>
								<div class="col-md-4">
									<input id="number" name="number" type="number"
										placeholder="" class="form-control input-md"> 
								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="textinput">commentaire</label>
								<div class="col-md-4">
									<input id="commentaire" name="commentaire" type="text"
										placeholder="" class="form-control input-md"> 
								</div>
							</div>

							<!-- Button -->
							<div class="form-group">
								<label class="col-md-4 control-label" for="singlebutton"></label>
								<div class="col-md-4">
									<button id="commander" name="commander"
										class="btn btn-primary" type="button">Commander</button>
								</div>
							</div>

						</fieldset>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

$(document).ready(function(){
	$("#commander").click(function(){
		$.ajax({
			  method: "POST",
			  url: "{{url('/sendCommande')}}",
			  headers : {
		            'X-CSRF-TOKEN' :"{{ csrf_token() }}"
		        },
			  data: { name: $("#name").val(), lieu:$("#lieu").val(), commentaire:$("#commentaire").val(), fil_rouge:$("#fil_rouge").val(), number:$("#number").val() }
			})
		  .done(function(  ) {
		    alert( "Commande envoyee");
		    $("#name").val("");
		    $("#lieu").val("");
		    $("#commentaire").val("");	
		    $("#number").val("");
		  })
		  .fail(function(  ) {
			  alert( "Une erreur est survenue, si le probleme persiste, merci de contacter le support technique" );
			});
	});
	
});
</script>
@endsection
