@extends('layouts.app')

@section('content')
	@include('layouts.dashboard.sidebar')
	@if (Auth::user ()->id == 1)
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header">List of Transactions</h1>
		<div class="table-responsive">
			<table class="table table-stripped table-hover">
				<thead>
					<tr>
						<th>Date Issued</th>
						<th>Item Description</th>
						<th>Quantity Transacted</th>
						<th>Transaction Cost</th>
						<th>Office / Supplier</th>
						<th>Stock At Hand</th>
						<th>Transaction Type</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transactions as $transaction)
						<tr>
							<td>{{ $transaction->transaction_date }}</td>
							<td>{{ $transaction->stock->desc }}</td>
							<td>{{ $transaction->quantity_transacted }}</td>
							<td>{{ $transaction->cost_quantity_transacted }}</td>
							@if($transaction->transaction_type == 1)
								@foreach ($transaction->incoming as $in)
									<td>{{ $in->supplier->name }}</td>
								@endforeach
							@else
								@foreach ($transaction->outgoing as $out)
									<td>{{ $out->location->loc_name }}</td>
								@endforeach
							@endif
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