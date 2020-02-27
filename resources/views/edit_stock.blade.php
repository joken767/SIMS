
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
      <h1 class="page-header">Edit Stock</h1>
			<div class="panel panel-default">
				<div class="panel-body">
					{!! Form::open (['route' => ['update_stock', $stock->id], 'method' => 'POST']) !!}
						<div class="row">
							<div class="col-md-5">      
					    	<div class="form-group">
						    	{{ Form::label ('complete_code', 'Complete Code') }}
						    	{{ Form::text ('complete_code', '155-' . $stock->stock_type . '-' . $stock->stock_code . '-' . $stock->item_no, ['class' => 'form-control', 'placeholder' => '', 'disabled']) }}
						  	</div>
					  	</div>
					  	<div class="col-md-4">
					    	<div class="form-group">
						    	{{ Form::label ('stock_type', 'Stock Type') }}
						    	{{ Form::text ('stock_type', $stock->stock_type, ['class' => 'form-control', 'placeholder' => '']) }}
						  	</div>
					  	</div>
						</div>
						<div class="row">
					  	<div class="col-lg-5">
					    	<div class="form-group">
						    	{{ Form::label ('stock_code', 'Stock Code') }}
						    	{{ Form::text ('stock_code', $stock->stock_code, ['class' => 'form-control', 'placeholder' => '']) }}
						  	</div>
					  	</div>
					  	<div class="col-lg-4">
					    	<div class="form-group">
						    	{{ Form::label ('item_no', 'Item Number') }}
						    	{{ Form::text ('item_no', $stock->item_no, ['class' => 'form-control', 'placeholder' => '']) }}
						  	</div>
					  	</div>
						</div>
						<div class="row">
					  	<div class="col-lg-5">
					    	<div class="form-group">
						    	{{ Form::label ('desc', 'Description') }}
						    	{{ Form::text ('desc', $stock->desc, ['class' => 'form-control', 'placeholder' => '']) }}
						  	</div>
					  	</div>
					  	<div class="col-lg-4">
					    	<div class="form-group">
						    	{{ Form::label ('unit', 'Unit') }}
						    	{{ Form::text ('unit', $stock->unit, ['class' => 'form-control', 'placeholder' => '']) }}
						  	</div>
					  	</div>
						</div>
						<div class="row">
							<div class="col-lg-5">
								<div class="form-group">
									{{ Form::label ('total_stocks_available', 'Total Stocks Available') }}
									{{ Form::number ('total_stocks_available', $stock->total_stocks_available, ['class' => 'form-control', 'disabled']) }}
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
								{{ Form::label ('exp_date', 'Expiry Date') }}
							  	{{ Form::date ('exp_date', $stock->exp_date, ['class'=>'form-control']) }}
								</div>
							</div>
						</div>
						<div class="row">
					  	<div class="col-lg-8">
					    	<div class="form-group">
						    
						  	</div>
					  	</div>
					  	<div class="col-lg-5">
              	{{ Form::submit ('Submit', ['class' => 'btn btn-primary']) }}
					  	</div>
						</div>
					{!! Form::close () !!}
			  </div>
			</div>
		</div>
  </div>
	
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header">List of Transactions for this Stock</h1>
		<div class="table-responsive">
			<table class="table table-stripped table-hover">
				<thead>
					<tr>
						<th>Transaction Date</th>
						<th>Qty. Received / Issued</th>
						<th>Unit Price</th>
						<th>RIS / PR</th>
						<th>Received From / Issued To</th>
						<th>PO</th>
						<th>Stock on Hand</th>
						<th>Transaction Type</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transactions as $transaction)
						<tr>
							<td>{{ $transaction->transaction_date }}</td>
							<td>{{ $transaction->quantity_transacted }}</td>
							<td>
								@if ($transaction->transaction_type == 1)
									<?php
										foreach ($stock_costs as $cost) {
											if ($transaction->incoming->first()->stock_cost_id == $cost->id) {
												echo $cost->unit_cost;
												break;
											}
										}
									?>
								@else
									<?php
										foreach ($stock_costs as $cost) {
											if ($transaction->outgoing->first()->stock_cost_id == $cost->id) {
												echo $cost->unit_cost;
												break;
											}
										}
									?>
								@endif
							</td>
							<td>
						  	@if ($transaction->transaction_type == 1)
									{{ $transaction->incoming->first()->pr_no }}
								@else
									{{ $transaction->outgoing->first()->ris_no }}
								@endif
							</td>
							@if($transaction->transaction_type == 1)
								@foreach ($transaction->incoming as $in)
									<td>{{ $in->supplier->name }}</td>
								@endforeach
							@else
								@foreach ($transaction->outgoing as $out)
									<td>{{ $out->location->loc_name }}</td>
								@endforeach
							@endif
							<td>
								@if ($transaction->transaction_type == 1)
									{{ $transaction->incoming->first()->po_no }}
								@else
									
								@endif
							</td>
							<td>{{ $transaction->stock_at_hand }}</td>
							<td>
								@if ($transaction->transaction_type == 1)
									Incoming
								@else
									Outgoing
								@endif
							</td>
							<td>
								<table>
									<tr>
										<td><a href="{{ url('/edit_transaction', $transaction->id) }}">{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</a></td>
										<td><a href="{{ url('/destroy_transaction', $transaction->id) }}">{{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}</a></td>
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