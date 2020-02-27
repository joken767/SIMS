@extends ('layouts.app')

@section ('content')
	@include ('layouts.dashboard.sidebar')
    @if (Auth::user ()->id == 1)
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Search Results</h1>
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                        <td>#</td>
                        <td>Complete Code</td>
                        <td>Description</td>
                        <td>Quantity</td>
                    </thead>
                    <tbody>
                        @foreach($results as $key => $result)
                        <tr>
							<td>{{ ++$key }}</td>
							<td>
                                {!! Form::open(array('action' => array('StockController@edit_stock', $result->id), 'method' => 'GET')) !!}
									<button type="submit" class="btn btn-success">155-{{ $result->stock_type }}-{{ $result->stock_code }}-{{ $result->item_no }}</button>
								{!! Form::close () !!}
							</td>
                            <td>{{ $result->desc }}</td>
                            <td>{{ $result->total_stocks_available }}</td>
                        </tr>
                        @endforeach
                    </tbody>
				</table>
				
            </div>
        </div>
    @endif
@endsection