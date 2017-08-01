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
				<h3 class="panel-title">Mot de Passe</h3>
			</div>
			<div class="panel-body">
				@if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
                <form action="{{route('password.update')}}" method="post" role="form" class="form-horizontal">
                    {{csrf_field()}}
 
                        <div class="form-group{{ $errors->has('old') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Ancien Mot de passe</label>
 
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="old" placeholder="Ancien Mot de passe" required>
 
                                @if ($errors->has('old'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('old') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
 
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Nouveau Mot de Passe</label>
 
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Nouveau Mot de Passe" required>
 
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
 
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Confirmer Mot de Passe</label>
 
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmer Mot de Passe" required>
 
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary form-control">Enregistrer</button>
                                </div>
                        </div>
                </form>
			</div>
		</div>
	</div>
	</div>
	
@endsection