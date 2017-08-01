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
				<h3 class="panel-title">Account</h3>
			</div>
			<div class="panel-body">
			@if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
				<form class="form-horizontal" role="form" method="POST" action="{{ route('parametres.update') }}">
					{{ csrf_field() }}
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	                  <label for="name" class="col-sm-2 control-label">Nom</label>

	                  <div class="col-md-7">
	                    <input type="text" class="form-control" name="name" placeholder="Saisissez le nom" value="{{ $user->name }}" required>

	                    @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif

	                  </div>
	                </div>

	                


	                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	                  <label for="email" class="col-sm-2 control-label">E-mail</label>

	                  <div class="col-md-7">
	                    <input type="email" class="form-control" name="email" placeholder="Saisissez l'e-mail" value="{{ $user->email }}" required>

	                    @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

	                  </div>
	                </div>

	                

	                <!-- <div class="form-group">
	                  <label for="tel" class="col-sm-2 control-label">Mots clés</label>

	                  <div class="col-md-6">
	                    <input type="text" value="" data-role="tagsinput" class="form-control" name="tags">
	                  </div>
	                </div> -->

	                
	                <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-primary form-control">Enregistrer</button>
                                </div>
                        </div>
            	</form>
			</div>
		</div>
	</div>
	</div>
	
@endsection