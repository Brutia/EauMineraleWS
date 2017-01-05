@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{URL::asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/jquery.dataTables.js')}}"></script>
<link href="{{URL::asset('css/jquery.dataTables.css')}}"
	rel='stylesheet' type='text/css'>
<link href="{{URL::asset('css/font-awesome.min.css')}}"
	rel='stylesheet' type='text/css'>

<div class="row">
	<div class="col-md-8 col-md-offset-2" id="status">
		@if($status!='')
			<div class="alert alert-success alert-dismissible" role="alert"><strong>Succ&egrave;s!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				La commande a &eacute;t&eacute; supprim&eacute;e!
			</div>
		@endif

	</div>

</div>


<div class="container">
	<div class="row">


	
		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default panel-table">
				<div class="panel-heading">
					<div class="row">
						<div class="col col-xs-6">
							<h3 class="panel-title">Commandes &agrave; traiter</h3>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-list" id="event_list">
						<thead>
							<tr>
								<th><em class="fa fa-cog"></em></th>
								<th class="hidden-xs">ID</th>
								<th>Nom demandeur</th>
								<th>Lieu</th>
								<th>Livraison pour:</th>
								<th>Nombre</th>
								@if($commandeEnCours)
									<th>Commande trait&eacute;e par</th>
								@endif
								
							</tr>
						</thead>
						<tbody>
							@foreach($commandes as $commande)
								<tr>
									<td>
										
										<div class="row">
											<div class="col-md-2">
												<a href="{{route('commandes.edit', ['id'=>$commande->id])}}" class="btn btn-default"><em class="fa fa-pencil"></em></a> 
											</div>
											<div class="col-md-2 col-md-offset-1">
												<form method="post" class="" action="{{route('commandes.destroy', ['id'=>$commande->id])}}" >
													<div class="">
													<input type="hidden" name="_method" value="DELETE">
													{!! csrf_field() !!}
													<button type="submit" class="btn btn-danger fa fa-trash" style="min-height:34px; min-width:38px"></button>
													</div>
												</form>
											</div>
											<div class="col-md-2 col-md-offset-1">
												
												<button class="btn btn-success glyphicon glyphicon-ok" key="{{$commande->id}}" style="min-height:34px; min-width:38px"></button>
													
											</div>
										</div>
									</td>
									<td class="hidden-xs">{{$commande->id}}</td>
									<td>{{$commande->name}}</td>
									<td>{{$commande->lieu}}</td>
									<td>{{$commande->date}}</td>
									<td>{{$commande->number}}</td>
									@if($commande->user)
										<td>{{$commande->user->name}}</td>
									@else 
										<td></td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
	
	$(document).ready( function () {
	    $('#event_list').DataTable({
		    "language":{
		    	"sProcessing":     "Traitement en cours...",
		    	"sSearch":         "Rechercher&nbsp;:",
		        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
		    	"sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
		    	"sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
		    	"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
		    	"sInfoPostFix":    "",
		    	"sLoadingRecords": "Chargement en cours...",
		        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
		    	"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
		    	"oPaginate": {
		    		"sFirst":      "Premier",
		    		"sPrevious":   "Pr&eacute;c&eacute;dent",
		    		"sNext":       "Suivant",
		    		"sLast":       "Dernier"
		    	},
		    	"oAria": {
		    		"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
		    		"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
		    	}}}
			    );
	} );
</script>

<script type="text/javascript">
	$(document).ready(function(){
		
		$(".btn-success").click(function(){
			$.ajax({
				  url: "{{url('admin/takeCommande')}}",
				  method: "POST",
				  data: { id : $(this).attr("key") },
				  headers : {
			            'X-CSRF-TOKEN' :"{{ csrf_token() }}"
			        }
				}).done(function() {
					$("#status").append('<div class="alert alert-success alert-dismissible" role="alert">\
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
							  <strong>Succès!</strong> Vous avez pris la commande!\
							</div>');
				});
			
		});
	});

</script>

@endsection

