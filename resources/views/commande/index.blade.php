@extends('layouts.app') @section('content')
<script type="text/javascript"
	src="{{URL::asset('js/jquery.dataTables.js')}}"></script>
<link href="{{URL::asset('css/jquery.dataTables.css')}}"
	rel='stylesheet' type='text/css'>
<link href="{{URL::asset('css/font-awesome.min.css')}}" rel='stylesheet'
	type='text/css'>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<div class="row">
	<div class="col-md-8 col-md-offset-2" id="status">
		@if($status!='')
		<div class="alert alert-success alert-dismissible" role="alert">
			<strong>Succ&egrave;s!</strong>
			<button type="button" class="close" data-dismiss="alert"
				aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
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
							<h3 class="panel-title">Commandes <input type="checkbox" checked data-toggle="toggle" data-on="&agrave; traiter" data-off="dans l'historique" id="toggle-event"></h3> 
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-list"
						id="event_list">
						<thead>
							<tr>
								<th class="hidden-xs">ID</th>
								<th>Nom demandeur</th>
								<th>Fil Rouge</th>
								<th>Lieu</th>
								<th>Livraison pour:</th>
								<th>Nombre</th> @if($commandeEnCours)
								<th>Commande trait&eacute;e par</th> @endif

								<th><em class="fa fa-cog"></em></th>

							</tr>
						</thead>

					</table>

				</div>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">

	var a_traiter = "oui";
	$(document).ready( function () {
		var jsonData;
		var table = $('#event_list').DataTable({
			"order": [[ 4, "asc" ]],
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
	    		}
		    },
		    "ajax": {
		        "url": "{{url('admin/getCommandes')}}"+"?a_traiter="+a_traiter
		    },
	        "columns": [
	                    { "data": "id" },
	                    { "data": "cname" },
	                    { "data": "nom"},
	                    { "data": "lieu" },
	                    { "data": "date" },
	                    { "data": "number" },
	                    { "data": "uname" },
	                    { "data": function( row){
	                    	var actions = '<div class="row">\
							<div class="col-md-2"> \
								<a href="{{route("commandes.index")}}/'+row.id+'/edit" class="btn btn-default"><em class="fa fa-pencil"></em></a>   \
							</div>\
							<div class="col-md-2 col-md-offset-1"> \
								<form method="post" class="" action="{{route("commandes.index")}}/'+row.id+'" >\
									<div class="">\
									<input type="hidden" name="_method" value="DELETE">\
									{!! csrf_field() !!}\
									<button type="submit" class="btn btn-danger fa fa-trash" style="min-height:34px; min-width:38px"></button>\
									</div>\
								</form>\
							</div>';
							if(row.uname == null){
								actions +='<div class="col-md-2 col-md-offset-1">\
								\
												<button class="btn btn-success glyphicon glyphicon-ok" key="'+row.id+'" style="min-height:34px; min-width:38px"></button>\
													\
											</div>\
										</div>'
							}
							return actions;
	                    }}
	                 
	                ]
		});

		setInterval( function () {
		    table.ajax.url("{{url('admin/getCommandes')}}"+"?a_traiter="+a_traiter).load( null, false ); // user paging is not reset on reload
		}, 5000 );
		
		$(document).on('click', '.btn-success', function(){
			$.ajax({
				  url: "{{url('admin/takeCommande')}}",
				  method: "POST",
				  data: { id : $(this).attr("key") },
				  headers : {
			            'X-CSRF-TOKEN' :"{{ csrf_token() }}"
			        }
				}).done(function() {
					$("#status").append('<div class="alert alert-success alert-dismissible" role="alert">\
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="dismiss">&times;</span></button>\
							  <strong>Succ&egrave;s!</strong> Vous avez pris la commande!\
							</div>');
					table.ajax.reload( null, false );
				});
		});
		$(document).on('click', ".dismiss",function(){

			$(".alert-dismissible").remove();
		});

		$('#toggle-event').change(function() {
			a_traiter = $(this).prop('checked')? "oui":"non";
			table.ajax.url("{{url('admin/getCommandes')}}"+"?a_traiter="+a_traiter).load( null, false ); // user paging is not reset on reload
			
		});
	});

</script>


@endsection

