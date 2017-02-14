<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Live wall</title>

<!-- Styles -->
<link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
<link href="{{asset('css/message_wall.css')}}" rel="stylesheet">
<!-- Scripts -->
<script>
	        window.Laravel = <?php
									echo json_encode ( [ 
											'csrfToken' => csrf_token () 
									] );
									?>
	    </script>
<script src="{{ URL::asset('js/app.js') }}"></script>


</head>

<body>
	<div class="container clearfix">
		<div class="chat">
			<div class="chat-history">
				<h2>Ecrivez votre propre message!</h2>
				<ul class="chat-ul">

				</ul>

			</div>
			<!-- end chat-history -->

		</div>

	</div>
	<div class="navbar navbar-default navbar-fixed-bottom">
		<div class="container">
			<p class="navbar-text pull-left">
				R&eacute;alis&eacute; par Guillaume ANDRES
			</p>

		</div>


	</div>
</body>

<script type="text/javascript">
	$(document).ready(function(){
		var currId = 0;
		var index = 0;

		
		function getMessage (){

			$.ajax( "{{url('/admin/live_messages' )}}"+"?id="+currId)
				  .done(function(data) {
					  if(data.length != undefined && data.length>0){
						  currId = data[data.length - 1].id; 
						  data.forEach(function(element) {
							  temp = "message_"+element.id;

							  if(index%2 == 0){
								  
								  $(".chat-ul").prepend("<li id="+temp+"></li>");
								  $("#"+temp).hide();
								  $("#"+temp).append('<div class="message-data">\
									<span class="message-data-name"><i class="fa fa-circle you"></i>'+element.name+'</span>\
									</div>\
									<div class="message you-message">'+element.message+'</div>');
								  $("#"+temp).show("slow");
							  }else{
								  $(".chat-ul").prepend("<li id="+temp+" class='clearfix'></li>");
								  $("#"+temp).hide();
								  $("#"+temp).append('<div class="message-data">\
											<span class="message-data-name"><i class="fa fa-circle me"></i>'+element.name+'</span></div>\
									<div class="message me-message">'+element.message+'</div>');
								  $("#"+temp).show("slow");
							  }
							  index++;
						  });
					  }
					  
				  })
				  .fail(function() {
				  	alert( "Une erreur est survenue" );
				  });
		}
		getMessage();
		setInterval( function () {
		    getMessage();
		}, 5000 );

		
	});
		

</script>

</html>