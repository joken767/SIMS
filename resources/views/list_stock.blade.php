@extends('layouts.app')

@section('content')
@include('layouts.dashboard.sidebar')
@if (Auth::user ()->id == 1)
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header">List of Items</h1>
		<div class="table-responsive">
			<table class="table table-stripped">
				<thead>
					<td>Complete Code</td>
					<td>Item Description</td>
					<td>Total Stocks Available</td>
					<td>Unit</td>
					<td>Actions</td>
				</thead>
				<tbody>
					@foreach($stocks as $stock)
						<tr>
							<td>155-{{ $stock->stock_type }}-{{ $stock->stock_code }}-{{ $stock->item_no }}</td>
							<td>{{ $stock->desc }}</td>
							<td>{{ $stock->total_stocks_available }}</td>
							<td>{{ $stock->unit }}</td>
							<td>
								<table>
									<tr>
										<td><a href="{{ url('/edit_stock', $stock->id) }}">{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</a></td>
										<td><a href="{{ url('/destroy_stock', $stock->id) }}">{{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}</a></td>
									</tr>
								</table>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	@endif
@endsection