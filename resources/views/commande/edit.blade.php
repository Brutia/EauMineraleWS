 @extends('layouts.app') @section('content')
 <link href="{{ URL::asset('css/edit.css') }}" rel="stylesheet">
 
 <div class="col-md-8 col-md-offset-3">
	<h2>Commande &agrave affecter</h2>
	<form method="POST"  action="{{ route('commandes.update',[$commande->id])}}">
		<input type="hidden" name="_method" value="put"/> 
		 {{ csrf_field() }}
		<label>Id :</label><input
			type="text" disabled class="span3" value={{$commande->id}}><br /> <br />
		<label>Nom du demandeur</label><input type="text" disabled class="span3"
			value={{$commande->name}}><br /> <br /> <br /> 
			
			
		<label>lieu :</label><input type="text" disabled
			class="span3" value={{$commande->lieu}}><br /> <br />
			
		 <label>Pour</label><input
			 type="text" disabled class="span3" value='{{$commande->date}}'><br />
		<br />

		<fieldset>
			<br /> <br />
			<div class="form-group">
				<label>Affecter la commande &agrave; </label>
				<div class="col-md-4">
					<select id="selectbasic" name="user_id" class="form-control">
						@foreach($admins as $key=>$admin)
							<option value="{{$key}}">{{$admin}}</option> 
						@endforeach
					</select>
				</div>
			</div>

		</fieldset>
		
		<br/>
		<button class="btn btn-primary" type="submit" value="Submit">Valider l'affectation</button>
	</form>
</div>
 
 
 
 
 @endsection
 