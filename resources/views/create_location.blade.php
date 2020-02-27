
@extends ('layouts.app')

@section ('content')
	@include ('layouts.dashboard.sidebar')
	@if (Auth::user ()->id == 1)
	<div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
		<h1 class='page-header'>Add Location</h1>
		<div class='panel panel-default'>
			<div class='panel-body'>
				<div class='row'>
					<div class='col-md-5'>
						{!! Form::open (['action' => 'StockController@store_location', 'method' => 'POST']) !!}
							<div class='form-group'>
								{{ Form::label ('loc_name', 'Location Name') }}
								{{ Form::text ('loc_name', '', ['class' => 'form-control']) }}
							</div>
					</div>
							<div class='row'>
								<div class='col-lg-8'>
									<div class='form-group'>
										
									</div>
								</div>
							</div>
							<div class='col-lg-5'>
								{{ Form::submit ('Add Location', ['class' => 'btn btn-success']) }}
							</div>
						{!! Form::close () !!}
				</div>
			</div>
		</div>
	</div>
	@endif
@endsection