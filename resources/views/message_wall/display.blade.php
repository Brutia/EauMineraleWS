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
				<ul class="chat-ul">
					<li>
						<h2>you feel like you're at full capacity with your current
							clients...</h2>
					</li>
					<li>
						<div class="message-data">
							<span class="message-data-name"><i class="fa fa-circle you"></i>
								You</span>
						</div>
						<div class="message you-message">A new client?!?! I would love to
							help them, but where are we going to find the time?</div>
					</li>
					<li class="clearfix">
						<div class="message-data">
							<span class="message-data-name">Ada, your OperationsAlly</span> <i
								class="fa fa-circle me"></i>
						</div>
						<div class="message me-message">We should take a look
							at your onboarding and service delivery workflows, for most
							businesess there are many ways to save time and not compromise
							quality.</div>
					</li>
					<li><h2>or little things are being forgotten that shouldn’t be...</h2></li>
					<li class="clearfix">
						<div class="message-data">
							<span class="message-data-name"><i class="fa fa-circle you"></i>
								You</span>
						</div>
						<div class="message you-message">What?! No way, how did I miss
							that. I never forgot that part before.</div>
					</li>
					<li class="clearfix">
						<div class="message-data align-right">
							<span class="message-data-name">Ada, your OperationsAlly</span> <i
								class="fa fa-circle me"></i>
						</div>
						<div class="message me-message float-right">Remembering everything
							can quickly become impossible as your business grows, we need to
							take a look at your reminder management system and also see if
							there are steps in your business we can automate.</div>
					</li>
					<li><h2>or you’ve started to notice mistakes and miscommunications
							...</h2></li>
					<li>
						<div class="message-data">
							<span class="message-data-name"><i class="fa fa-circle you"></i>
								You</span>
						</div>
						<div class="message you-message">6? Bob told me 8! How did this
							mix up happen?!</div>
					</li>
					<li class="clearfix">
						<div class="message-data align-right">
							<span class="message-data-name">Ada, your OperationsAlly</span> <i
								class="fa fa-circle me"></i>
						</div>
						<div class="message me-message float-right">The more people in
							your business, the more opportunity for mistakes, having a solid
							system in place for tracking important client data will help
							avoid these miscommunications.</div>
					</li>
					<li><h2>or it can be hard to find the information you need ...</h2></li>
					<li>
						<div class="message-data">
							<span class="message-data-name"><i class="fa fa-circle you"></i>
								You</span>
						</div>
						<div class="message you-message">I know that I spoke with Mary
							about this, but where did I put that note...hopefully she also
							sent me an email...</div>
					</li>
					<li class="clearfix">
						<div class="message-data align-right">
							<span class="message-data-name">Ada, your OperationsAlly</span> <i
								class="fa fa-circle me"></i>
						</div>
						<div class="message me-message float-right">Finding the right
							information when you need it will save you time and energy. Your
							data management systems need to grow with your business. All
							businesses need a dynamic data strategy and a system to ensure
							that the strategy is implemented correctly.</div>
					</li>
				</ul>

			</div>
			<!-- end chat-history -->

		</div>
		
	</div>
</body>

</html>