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
				<h3 class="panel-title">Mise en Forme</h3>
			</div>
			<div class="panel-body">
			@if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
				<form class="form-horizontal" role="form" method="POST" 
				action="{{ route('parametres.updateforme') }}">
					{{ csrf_field() }}

				<div class="form-group{{ $errors->has('nombre_sidebar') ? ' has-error' : '' }}">
                                <label for="nombre_sidebar" class="col-sm-4 control-label">Nombre de widget </label>
 
                                <div class="col-md-6">
                        
                                	@php $sidebars = ['2', '1']; @endphp
                                	<select class="form-control" id="nombre_sidebar" name="nombre_sidebar">
	                                	@foreach($sidebars as $sidebar)
							<option value="{{$sidebar}}" {{$miseforme->nombre_sidebar == $sidebar ? 'selected' : ''}}>{{$sidebar}}</option>
	                                	@endforeach
                                	</select>
                                	
                                     
                                    @if ($errors->has('nombre_sidebar'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('nombre_sidebar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

	                


	                <div class="form-group{{ $errors->has('article_par_page') ? ' has-error' : '' }}">
	                  <label for="article_par_page" class="col-sm-4 control-label">Article Par Page</label>

	                  <div class="col-md-6">
	                    <input type="number" class="form-control" name="article_par_page"  value="{{ $miseforme->article_par_page }}" required>

	                    @if ($errors->has('article_par_page'))
                            <span class="help-block">
                                <strong>{{ $errors->first('article_par_page') }}</strong>
                            </span>
                        @endif

	                  </div>
	                </div>

	                <div class="form-group{{ $errors->has('color_background') ? ' has-error' : '' }}">
	                  <label for="color_background" class="col-md-4 control-label">Couleur Arriere plan</label>

	                  <div class="col-md-2">
	                    <input type="color" name="color_background"  value="{{ $miseforme->color_background }}" required>

	                    @if ($errors->has('color_background'))
                            <span class="help-block">
                                <strong>{{ $errors->first('color_background') }}</strong>
                            </span>
                        @endif

	                  </div>
	                </div>

	                <div class="form-group{{ $errors->has('color_widget') ? ' has-error' : '' }}">
	                  <label for="color_widget" class="col-md-4 control-label">Couleur Sidebar</label>

	                  <div class="col-md-2">
	                    <input type="color" name="color_widget"  value="{{ $miseforme->color_widget }}" required>

	                    @if ($errors->has('color_widget'))
                            <span class="help-block">
                                <strong>{{ $errors->first('color_widget') }}</strong>
                            </span>
                        @endif

	                  </div>
	                </div>

	                

	                <!-- <div class="form-group">
	                  <label for="tel" class="col-sm-2 control-label">Mots clés</label>

	                  <div class="col-sm-10">
	                    <input type="text" value="" data-role="tagsinput" class="form-control" name="tags">
	                  </div>
	                </div> -->

	                
	                <div class="form-group">
	                    <div class="col-md-6 col-md-offset-4">
	                        <button type="submit" class="btn btn-primary btn-toastr">Enregistrer</button>
	                        <button type="reset" class="btn btn-danger btn-toastr">réinitialiser defaut</button>
	                    </div>
                	</div>
            	</form>
			</div>
		</div>
	</div>
	</div>
	
@endsection