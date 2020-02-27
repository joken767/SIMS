@extends('layouts.app')

@section('content')
	@include('layouts.dashboard.sidebar')
	@if (Auth::user ()->id == 1)
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	@if ($errors->any())
						<div class="alert alert-danger">
								<ul>
										@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
										@endforeach
								</ul>
						</div>
				@endif
		<h1 class="page-header">Inventory of Supplies and Materials Carried on Stock</h1>
		<div class="panel panel-default">
			  <div class="panel-body">
				<div class="row">
					{!! Form::open(['action' => 'StockController@search_carried_stock', 'method' => 'GET']) !!}
					  <div class="col-lg-10">
					    <div class="form-group">
					    	{{ Form::label ('date', 'As of:') }}
					    	{{ Form::date ('date', null, ['class'=>'form-control']) }}
						  </div>
					  </div><!-- /.col-lg-6 -->
					  <div class="col-lg-4">
					    <div class="form-group">
						    {{ Form::submit ('Submit', ['class' => 'btn btn-primary']) }}
						  </div>
					  </div><!-- /.col-lg-6 -->
					{!! Form::close() !!}
				</div><!-- /.row -->
			  </div>
			  </div>
			  <h1 class="page-header">List of Items Carried on Stock</h1>
		<div class="table-responsive">
			<table class="table table-stripped">
				<thead>
					<td>#</td>
					<td>Complete Code</td>
					<td>Description</td>
					<td>Unit Cost</td>
					<td>Stocks On Hand</td>
					<td>Total Cost of Stock On Hand</td>
				</thead>
				<tbody>
					@if(!empty($stocks_carried))
						@foreach($stocks_carried as $key => $stock_carried)
							<tr>
								<td>{{ ++$key }}</td>
								<td>155-{{ $stock_carried->stock->stock_type }}-{{ $stock_carried->stock->stock_code }}-{{ $stock_carried->stock->item_no }}</td>
								<td>{{ $stock_carried->stock->desc }}</td>
								<td>{{ $stock_carried->stock->stock_costs->first()->unit_cost }}</td>
								<td>{{ $stock_carried->stock_at_hand }}</td>
								<td>{{ $stock_carried->cost_stock_at_hand }}</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
			@if(!empty($stocks_carried))
				@if (count($stocks_carried) >= 1)
					<a href="/print_carried_stock/{{$dated}}" class="btn btn-success">Print Document</a>
				@endif
			@endif
			</div>
			@endif
@endsection