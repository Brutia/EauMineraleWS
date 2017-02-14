@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{URL::asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
<link href="{{URL::asset('css/jquery.dataTables.min.css')}}"
	rel='stylesheet' type='text/css'>
<link href="{{URL::asset('css/font-awesome.min.css')}}"
	rel='stylesheet' type='text/css'>

<div class="container">
	<div class="row">


	
		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default panel-table">
				<div class="panel-heading">
					<div class="row">
						<div class="col col-xs-6">
							<h3 class="panel-title">Liste des messages du live wall</h3>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-list" id="fil_rouge_list">
						<thead>
							<tr>
								<th class="hidden-xs">ID</th>
								<th>Nom ou pseudo</th>
								<th>Message</th>
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
	$(document).ready( function () {
		var table = $('#fil_rouge_list').DataTable({
			"order": [[ 0, "desc" ]],
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
		        "url": "{{url('admin/live_messages')}}"+"?id=0",
		        "dataSrc" : function(json){
					return json;
		        }
		    },
	        "columns": [
	                    { "data": "id" },
	                    { "data": "name" },
	                    { "data": "message"},
	                    { "data": function( row){
		                    currId=row.id;
		                    //console.log(currId);
	                    	var actions = '<div class="row">\
							<div class="col-md-2 col-md-offset-1"> \
								<form method="post" class="" action="{{route("wall_message.index")}}/'+row.id+'" >\
									<div class="">\
									<input type="hidden" name="_method" value="DELETE">\
									{!! csrf_field() !!}\
									<button type="submit" class="btn btn-danger fa fa-trash" style="min-height:34px; min-width:38px"></button>\
									</div>\
								</form>\
							</div>'
							return actions;
	                    }}
	                ]
		});

		setInterval( function () {
		    table.ajax.url("{{url('admin/live_messages')}}"+"?id=0").load( null, false ); // user paging is not reset on reload
		}, 5000 );
	    });
</script>

@endsection

