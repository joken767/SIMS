<?php
	use App\Stock_Cost;
?>

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
		<h1 class="page-header">Report of Supplies and Materials Issued</h1>
		<div class="panel panel-default">
			  <div class="panel-body">

				<div class="row">
				  {!! Form::open (['action' => 'StockController@search_report_issued_stock', 'method' => 'GET']) !!}
				  <div class="col-md-2">
				    <div class="form-group">
					    {{ Form::label ('from', 'From: ') }}
					    {{ Form::date ('from', null, ['class'=>'form-control']) }}
					  </div>
				  </div><!-- /.col-lg-6 -->
				  <div class="col-md-2">
				    <div class="form-group">
					    {{ Form::label ('to', 'To: ') }}
					    {{ Form::date ('to', null, ['class'=>'form-control']) }}
					  </div>
				  </div><!-- /.col-lg-6 -->
				  <div class="col-md-2">
				    <div class="form-group">
					    {{ Form::label ('version', 'Version') }}
					    {{ Form::select ('version', ([1 => 'New Version',2 => 'Old Version']), null, (['class'=>'form-control'])) }}
					</div>
				</div>
			</div>
				  <div class='col-md-2'>
				  	<div class='form-group'>
				  		{{ Form::submit ('Submit', ['class' => 'btn btn-success']) }}
				  	</div>
				  </div>
				  {!! Form::close() !!}
				</div><!-- /.row -->
			  </div>
			  </div>

@if(!empty($stocks))
	@if($request->version == 1)
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div class="table-responsive">
				<table class="table table-stripped table-hover">
					<thead>
						<tr>
							<th>Total</th>
							<th>Description</th>
							@foreach($locations as $location)
								<th>{{ $location->loc_name }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($stocks as $stock)
							<tr>
								<td>
									<?php
										$temp = 0;

										foreach ($transactions as $transaction) {
											if ($transaction->stock_id == $stock->id && $transaction->transaction_type == 2) {
												$temp += $transaction->quantity_transacted;
											}
										}
									?>
									{{ $temp }}
								</td>
								<td>{{ $stock->desc }}</td>
								@foreach ($locations as $key => $location)
									<?php
										$temp = 0;

										foreach ($transactions as $transaction) {
											foreach ($transaction->outgoing as $out) {
												if ($out->location_id == $location->id && $transaction->stock_id == $stock->id) {
													$temp += $transaction->quantity_transacted;
												}
											}
										}
									?>
									<td>{{ $temp }}</td>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@if(!empty($stocks))
					@if (count($stocks) >= 1)
						{!! Form::open (['action' => 'StockController@print_issued_stocks', 'method' => 'POST']) !!}
							{{ Form::hidden ('from', session ('from')) }}
							{{ Form::hidden ('to', session ('to')) }}
							{{ Form::hidden ('version', session ('version')) }}
							{{ Form::submit ('Print Document', ['class' => 'btn btn-success']) }}
							
						{!! Form::close () !!}
					@endif
				@endif
		</div>
	@else
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<div class="table-responsive">
					<table class="table table-stripped table-hover">
						<thead>
							<tr>
								<th>Complete Code</th>
								<th>Description</th>
								<th>Quantity Issued</th>
								<th>Unit Cost</th>
								<th>Total Cost</th>
							</tr>
						</thead>
						<tbody>
							@foreach($stocks as $stock)
								<tr>
									<td>155-{{ $stock->stock_type }}-{{ $stock->stock_code }}-{{ $stock->item_no }}</td>
									<td>{{ $stock->desc }}</td>
									<td>
										<?php
											$temp = 0;

											foreach ($transactions as $transaction) {
												if ($transaction->stock_id == $stock->id && $transaction->transaction_type == 2) {
													$temp += $transaction->quantity_transacted;
												}
											}
										?>
										{{ $temp }}
									</td>
									<td>
										<?php
											$stock_cost = Stock_Cost::where('stock_id', $stock->id)
												->orderBy('updated_at', 'DESC')->get();
											
											if(count($stock_cost) > 0) {
												$stock_cost = (float)$stock_cost->first()->unit_cost;
											} else {
												$stock_cost = 0.00;
											}
										?>
										{{ (float)$stock_cost }}
									</td>
									<td>
										<?php
											$total_cost = (float)$stock_cost * (float)$temp;
										?>
										{{ $total_cost }}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@if(!empty($stocks))
					@if (count($stocks) >= 1)
						{!! Form::open (['action' => 'StockController@print_issued_stocks', 'method' => 'POST']) !!}
							{{ Form::hidden ('from', session ('from')) }}
							{{ Form::hidden ('to', session ('to')) }}
							{{ Form::hidden ('version', session ('version')) }}
							{{ Form::submit ('Print Document', ['class' => 'btn btn-success']) }}
							
						{!! Form::close () !!}
					@endif
				@endif
			</div>
	@endif
@endif
@endif
@endsection