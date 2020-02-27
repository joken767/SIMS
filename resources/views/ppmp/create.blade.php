@extends ('layouts.app')

@section ('content')
	@include ('layouts.dashboard.sidebar')
	    @if (Auth::user ()->id != 1)
            <div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
                <h1 class='page-header'>Submit PPMP Request</h1>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        {!! Form::open (['action' => 'PPMPController@generate', 'method' => 'POST']) !!}
                            <div class='row'>
                                <div class='col-lg-8'>		
                                    <div class='form-group'>
                                        {{ Form::hidden ('year', date ("Y")) }}
                                    </div>
                                </div>
                                <div class='col-lg-8'>
                                    {{ Form::submit ('Generate PPMP Request', ['class' => 'btn btn-success']) }}
                                </div>
                            </div>
                        {!! Form::close () !!}
                    </div>
                </div>
            </div>
        @endif
@endsection