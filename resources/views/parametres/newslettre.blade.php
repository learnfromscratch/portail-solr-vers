@extends ('layouts.app')

@section('content')

	<div class="row parametres">
		<div class="col-md-3 col-md-offset-1">
			
				<ul class="liste-parameters">
					<a href="{{route('parametres.show')}}" class="{{$string == 'account' ? 'active' : ''}}"><li><i class="fa fa-user" aria-hidden="true"></i>
Account<i class="fa fa-angle-right" aria-hidden="true"></i>

					</li></a>
					<a href="{{route('password.show')}}" class="{{$string == 'password' ? 'active' : ''}}"><li><i class="fa fa-unlock-alt" aria-hidden="true"></i>
Mot de Passe<i class="fa fa-angle-right" aria-hidden="true"></i>

					</li></a>
					<a href="{{route('newslettre.show')}}" class="{{$string == 'newslettre' ? 'active' : ''}}"><li><i class="fa fa-envelope" aria-hidden="true"></i>
NewsLettre<i class="fa fa-angle-right" aria-hidden="true"></i>

					</li></a>
					<a href="{{route('parametres.view')}}" class="{{$string == 'miseforme' ? 'active' : ''}}"><li><i class="fa fa-fort-awesome" aria-hidden="true"></i>
Mise en Forme<i class="fa fa-angle-right" aria-hidden="true"></i>

					</li></a>
					
				</ul>	
	        
		</div>

		<div class="col-md-6">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">Newslettre</h3>
				
			</div>
			<div class="panel-body">
				@if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
                <form action="{{route('newslettre.update')}}" method="post" role="form" class="form-horizontal">
                    {{csrf_field()}}
 
                        
 
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	                  			<label for="email" class="col-md-4 control-label">E-mail</label>

				                  <div class="col-sm-6">
				                    <input type="email" class="form-control" name="email" placeholder="Saisissez l'e-mail" value="{{$newslettre->email == '' ? $email : $newslettre->email}}" required>

				                    @if ($errors->has('email'))
			                            <span class="help-block">
			                                <strong>{{ $errors->first('email') }}</strong>
			                            </span>
			                        @endif

				                  </div>
	                		</div>
 
                            <div class="form-group{{ $errors->has('periode_newslettre') ? ' has-error' : '' }}">
                                <label for="periode_newslettre" class="col-sm-4 control-label">Periode Newslettre</label>
 
                                <div class="col-md-6">
                                	@php $periodes = ['chaque jour', 'chaque semaine', 'chaque mois']; @endphp
                                	<select class="form-control" id="periode_newslettre" name="periode_newslettre">
	                                	@foreach($periodes as $periode)
							<option value="{{$periode}}" {{$newslettre->periode_newslettre == $periode ? 'selected' : ''}}>{{$periode}}</option>
	                                	@endforeach
                                	</select>
                                	
                                     
                                    @if ($errors->has('periode_newslettre'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('periode_newslettre') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('envoi_newslettre') ? ' has-error' : '' }}">
                                <label for="envoi_newslettre" class="col-md-4 control-label"></label>
 
                                <div class="col-md-6">
                                  <input type="hidden" name="envoi_newslettre" value="0">
								  <input type="checkbox" class="" value="1" name="envoi_newslettre" {{$newslettre->envoi_newslettre == 1 ? 'checked' : ''}}>
								 	
								  <span class="custom-control-description"> Activer l'envoie de la Newslettre</span>
                                </div>
                            </div>
 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary form-control">Enregistrer</button>
                                </div>
                        </div>
                </form>
                @if($newslettre->envoi_newslettre == 1)
                <em><i class="fa fa-info-circle" aria-hidden="true"></i>
La prochaine Newslettre sera envoyé le <strong>{{$newslettre->date_envoie_newslettre}}</strong> à 20:00</em>
			@else
			<em><i class="fa fa-info-circle" aria-hidden="true"></i>
Veuillez Activer l'envoie de la Newslettre ...</em>
@endif
			</div>
		</div>
	</div>
	</div>
	
@endsection