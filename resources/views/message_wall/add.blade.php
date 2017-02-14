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
							<legend>Mettre un message sur le mur</legend>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="textinput">Nom ou pseudo</label>
								<div class="col-md-4">
									<input id="name" name="name" type="text"
										placeholder="" class="form-control input-md"> 
								</div>
							</div>
							<!-- Textarea -->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="textarea">Votre message</label>
							  <div class="col-md-4">                     
							    <textarea class="form-control" id="message" name="message" placeholder="Votre message"></textarea>
							  </div>
							</div>

							<!-- Button -->
							<div class="form-group">
								<label class="col-md-4 control-label" for="singlebutton"></label>
								<div class="col-md-4">
									<button id="envoyer" name="envoyer"
										class="btn btn-primary" type="button">Envoyer!</button>
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
	$("#envoyer").click(function(){
		if($("#message").val()==""){
			alert("Merci d'ecrire un message");
		}else{
			
			$.ajax({
				  method: "POST",
				  url: "{{url('/store_live_wall')}}",
				  headers : {
			            'X-CSRF-TOKEN' :"{{ csrf_token() }}"
			        },
				  data: { name: $("#name").val(), message:$("#message").val() }
				})
			  .done(function(  ) {
			    alert( "Message envoye");
			    $("#name").val("");
			    $("#message").val("");
			  })
			  .fail(function(  ) {
				  alert( "Une erreur est survenue, si le probleme persiste, merci de contacter le support technique" );
				});
		}
	});
	
});
</script>
@endsection
