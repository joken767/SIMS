
@extends ('layouts.app')

@section ('content')
	@include ('layouts.dashboard.sidebar')
	@if (Auth::user ()->id == 1)
	<div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
		<h1 class='page-header'>Search Stock</h1>
		<div class='panel panel-default'>
			<div class='panel-body'>
				<div class='row'>
					<div class='col-md-5'>
						{!! Form::open (['action' => 'StockController@search_stock', 'method' => 'POST']) !!}
							<div class='form-group'>
								{{ Form::label ('search', 'Search: ') }}
								{{ Form::text ('search', '', ['class' => 'form-control']) }}
							</div>
					</div>
							<div class='row'>
								<div class='col-lg-8'>
									<div class='form-group'>
											{{ Form::hidden ('pr_no', $request->input('pr_no')) }}
											{{ Form::hidden ('po_no', $request->input('po_no')) }}
											{{ Form::hidden ('supplier_id', $request->input('supplier_id')) }}
											{{ Form::hidden ('date_received', $request->input('date_received')) }}
									</div>
								</div>
							</div>
							<div class='col-lg-5'>
								{{ Form::submit ('Submit', ['class' => 'btn btn-success']) }}
							</div>
						{!! Form::close () !!}
				</div>
			</div>
		</div>
    </div>
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
								<form method="POST" action="/stocks/{{ $result->id }}">
									{{ Form::hidden ('pr_no', $request->input('pr_no')) }}
									{{ Form::hidden ('po_no', $request->input('po_no')) }}
									{{ Form::hidden ('supplier_id', $request->input('supplier_id')) }}
									{{ Form::hidden ('date_received', $request->input('date_received')) }}
									<button type="submit" class="btn btn-success">155-{{ $result->stock_type }}-{{ $result->stock_code }}-{{ $result->item_no }}</button>
								</form>
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