<?php
	use App\To_Be_Received;
	use App\Stock;
	use App\Stock_Cost;

	$to_be_received = To_Be_Received::all ();
	$check = 0;

	if (count ($to_be_received) > 0) {
		$check = 1;
	}
?>
@extends ('layouts.app')

@section ('content')
	@include ('layouts.dashboard.sidebar')
	@if (Auth::user ()->id == 1)
	<div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
		<h1 class='page-header'>Search Items to Receive</h1>
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
										@if (isset ($request->pr_no))
												{{ Form::hidden ('pr_no', $request->input('pr_no')) }}
												{{ Form::hidden ('po_no', $request->input('po_no')) }}
												{{ Form::hidden ('supplier_id', $request->input('supplier_id')) }}
												{{ Form::hidden ('receive', true) }}
												{{ Form::hidden ('date_received', $request->input('date_received')) }}
											@else
												{{ Form::hidden ('receive', true) }}
											@endif
									</div>
								</div>
							</div>
							<div class='col-lg-12'>
								{{ Form::submit ('Submit', ['class' => 'btn btn-success col-md-1']) }}
								<p class="col-md-4">If the item is not yet availalbe, please click on the button: </p>
								<span type="button" class="btn btn-primary col-md-1" id="create_stock">Create Stock
						    	</span>
							</div>
						{!! Form::close () !!}
				</div>
			</div>
		</div>
	</div>
	@endif
	@if(isset($results))
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Search Results</h1>
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                        <td>#</td>
                        <td>Complete Code</td>
                        <td>Description</td>
                        <td>Quantity</td>
												<td>Actions</td>
                    </thead>
                    <tbody>
                        @foreach($results as $key => $result)
                        <tr>
							<td>{{ ++$key }}</td>
							<td>
								{!! Form::open (['route' => ['receive_stock', $result->id], 'method' => 'POST']) !!}
									@if (isset ($request->pr_no))
										{{ Form::hidden ('pr_no', $request->input('pr_no')) }}
										{{ Form::hidden ('po_no', $request->input('po_no')) }}
										{{ Form::hidden ('supplier_id', $request->input('supplier_id')) }}
										{{ Form::hidden ('date_received', $request->input('date_received')) }}
									@endif
									155-{{ $result->stock_type }}-{{ $result->stock_code }}-{{ $result->item_no }}
							</td>
                            <td>{{ $result->desc }}</td>
                            <td>{{ $result->total_stocks_available }}</td>
														<td>{{ Form::submit ('Receive', ['class' => 'btn btn-primary']) }}</td>
                        </tr>
												{!! Form::close () !!}
                        @endforeach
                    </tbody>
				</table>
				
            </div>
        </div>
	@endif
	@if(isset($stock))
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Item Information</h1>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								{{ Form::label ('complete_code', 'Complete Code') }}
								{{ Form::text ('complete_code', '155-' . $stock->stock_type . '-' . $stock->stock_code . '-' . $stock->item_no, ['class' => 'form-control', 'placeholder' => '', 'disabled']) }}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{{ Form::label ('quantity', 'Total Stocks Available') }}
								{{ Form::text ('quantity', $stock->total_stocks_available, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								{{ Form::label ('stock_type', 'Stock Type') }}
								{{ Form::text ('stock_type', $stock->stock_type, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{{ Form::label ('desc', 'Description') }}
								{{ Form::text ('desc', $stock->desc, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
							  {{ Form::label ('stock_code', 'Stock Code') }}
							  {{ Form::text ('stock_code', $stock->stock_code, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div>
						<div class="col-md-4">
						  <div class="form-group">
							  {{ Form::label ('unit', 'Unit') }}
							  {{ Form::text ('unit', $stock->unit, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
						  <div class="form-group">
							  {{ Form::label ('item_no', 'Item Number') }}
							  {{ Form::text ('item_no', $stock->item_no, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div>
						<div class="col-lg-4">
						  <div class="form-group">
							  {{ Form::label ('exp_date', 'Expiry Date') }}
							  {{ Form::date ('exp_date', $stock->exp_date, ['class'=>'form-control', 'readonly']) }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Receive Information (Please Fill Up)</h1>
			<div class="panel panel-default">
				<div class="panel-body">
					{!! Form::open (['action' => 'StockController@update_receive_stock', 'method' => 'POST']) !!}
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									{{ Form::label ('stock_cost', 'Unit Price') }}
									<div class="input-group">
										{{ Form::select('stock_cost', $stock_costs->pluck ('unit_cost', 'id'), null, ['class'=>'form-control', 'id'=>'stock_cost_select']) }}
										<span type="button" class="btn btn-primary input-group-addon btn-block" id="create_uPrice">
							    		<span class="glyphicon glyphicon-plus"></span>
							    	</span>
								</div>
							</div>
							</div>
							<div class="col-lg-4">
						  	<div class="form-group">
						    {{ Form::label ('supplier_label', 'Supplier') }}
						    <div class="input-group">
						    	{{ Form::select('supplier_id', $suppliers->pluck ('name', 'id'), null, ['class'=>'form-control', 'id' => 'supplier_select']) }}
							    	<span type="button" class="btn btn-primary input-group-addon btn-block" id="create_supplier">
							    		<span class="glyphicon glyphicon-plus"></span>
							    	</span>
							</div>
						</div>
							</div>
					  </div>
						<div class="row">
							<div class="col-md-5">
						  	<div class="form-group">
									{{ Form::label ('pr_no', 'PR Number') }}
							  	{{ Form::text ('pr_no', '', ['class' => 'form-control', 'placeholder' => 'PLEASE FILL THIS UP']) }}
								</div>
							</div>
							<div class="col-md-4">
						  	<div class="form-group">
									{{ Form::label ('po_no', 'PO Number') }}
							  	{{ Form::text ('po_no', '', ['class' => 'form-control', 'placeholder' => 'PLEASE FILL THIS UP']) }}
								</div>
							</div>
					  </div>
						<div class="row">
							<div class="col-md-5">
						  	<div class="form-group">
									{{ Form::label ('quantity_received', 'Quantity To Be Received') }}
									{{ Form::number ('quantity_received', '', ['class' => 'form-control', 'placeholder' => 'PLEASE FILL THIS UP']) }}
								</div>
							</div>
							<div class="col-md-4">
						  	<div class="form-group">
									{{ Form::label ('date_received', 'Date Received') }}
									{{ Form::date ('date_received', null, ['class'=>'form-control']) }}
								</div>
							</div>
					  </div>
					  <div class="row">
							<div class="col-lg-8">
						  	<div class="form-group">
							  
								</div>
							</div>
							<div class="col-lg-5">
								{{ Form::hidden('stock_id', $stock->id) }}
						  	{{ Form::submit ('Add To Receiving Cart', ['class' => 'btn btn-primary']) }}
							</div>
					  </div>
				  {!! Form::close () !!}
				</div>
			</div>
		</div>		

		<div class="modal fade" id="create_uPrice_modal" tabindex="-1" aria-hidden="true">
		    <div class="modal-dialog" role="document" style="width: 400px;">
		    	<div class="panel panel-primary">
		        	<div class="panel-heading">
		            	<h4>Details</h4> 
		          	</div>
			        <div class="panel-body">
			            <div class='row'>
							<div class='col-md-12'>
								<form id="unit_price_form" method="POST" action="{{ url('store_stock_cost') }}">
									<div class='form-group'>
										{{ Form::label ('stock_cost', 'Unit Price') }}
										{{ Form::text ('stock_cost', '', ['class' => 'form-control', 'id' => 'stock_cost_field', 'required']) }}
									</div>
								</div>
							</div>
							<div class="row">
								<div class='col-md-3'>
									{{ Form::hidden ('stock_id', $stock->id) }}
									{{ Form::submit ('Add Unit Price', ['class' => 'btn btn-success']) }}
									
								</div>
								{!! Form::close () !!}
							</div>
						</div>
			        </div>
		      	</div>
		    </div>

		    <script type="text/javascript">
		    		$('#create_uPrice').click(function(event) {
					    event.preventDefault();
					    $('#create_uPrice_modal').modal('show');
					});

		    		$('#unit_price_form').submit(function( event ) {
					    event.preventDefault();
					    $.ajax({
					        url: '/store_stock_cost',
					        type: 'post',
					        data: $( this ).serialize(),
					    });
					    $('#create_uPrice_modal').modal('hide');
					    fetch_stock_cost();
					});

					function fetch_stock_cost () {
						$('#stock_cost_select').empty();
						$.ajax({
						  url: "/fetch_uPrice/{{$stock->id}}",
						  success: function( data ) {
						    parsed_data = $.parseJSON(JSON.stringify(data));
							$.each(parsed_data, function(key, val) {   
							   $('#stock_cost_select')
							        .append(
							        	$('<option>', { value : parsed_data[key].id })
							        					.text(parsed_data[key].unit_cost));
							});
						  }
						});
					}

		    </script>

	@endif
	<div class="modal fade" id="create_stock_modal" tabindex="-1" aria-hidden="true">
		    <div class="modal-dialog" role="document" style="width: 400px;">
		    	<div class="panel panel-primary">
		        	<div class="panel-heading">
		            	<h4>Details</h4> 
		          	</div>
			        <div class="panel-body">
			            <div class='row'>
							<div class='col-md-12'>
								<form id="store_stock_form" method="POST" action="{{ url('store_stock') }}">
									<div class='form-group'>
										{{ Form::label ('complete_code', 'Complete Code') }}
						    			{{ Form::text ('complete_code', '', ['class' => 'form-control', 'placeholder' => 'WILL BE AUTOMATICALLY GENERATED', 'disabled']) }}
						    			{{ Form::label ('stock_type', 'Stock Type') }}
						   				{{ Form::text ('stock_type', '', ['class' => 'form-control', 'placeholder' => '']) }}
						   				{{ Form::label ('stock_code', 'Stock Code') }}
						    			{{ Form::text ('stock_code', '', ['class' => 'form-control', 'placeholder' => '']) }}
						    			{{ Form::label ('item_no', 'Item Number') }}
									    {{ Form::text ('item_no', '', ['class' => 'form-control', 'placeholder' => '']) }}
									    {{ Form::label ('desc', 'Description') }}
									    {{ Form::text ('desc', '', ['class' => 'form-control', 'placeholder' => '']) }}
									    {{ Form::label ('unit', 'Unit') }}
									    {{ Form::text ('unit', '', ['class' => 'form-control', 'placeholder' => '']) }}
									    {{ Form::label ('exp_date', 'Expiry Date') }}
						    			{{ Form::date ('exp_date', null, ['class'=>'form-control']) }}
									    
									</div>
								</div>
							</div>
							<div class="row">
								<div class='col-md-3'>
									{{ Form::submit ('Add Stock', ['class' => 'btn btn-success']) }}
									
								</div>
								{!! Form::close () !!}
							</div>
						</div>
			        </div>
		      	</div>
		    </div>

		    <div class="modal fade" id="create_supplier_modal" tabindex="-1" aria-hidden="true">
		    <div class="modal-dialog" role="document" style="width: 400px;">
		    	<div class="panel panel-primary">
		        	<div class="panel-heading">
		            	<h4>Details</h4> 
		          	</div>
			        <div class="panel-body">
			            <div class='row'>
							<div class='col-md-12'>
								<form id="store_supplier_form" method="POST" action="{{ url('store_supplier') }}">
									<div class='form-group'>
										{{ Form::label ('name', 'Supplier Name') }}
										{{ Form::text ('name', '', ['class' => 'form-control', 'id' => 'supplier_name_field', 'required']) }}
									</div>
								</div>
							</div>
							<div class="row">
								<div class='col-md-3'>
									{{ Form::submit ('Add Supplier', ['class' => 'btn btn-success']) }}
									
								</div>
								{!! Form::close () !!}
							</div>
						</div>
			        </div>
		      	</div>
		    </div>
<script type="text/javascript">
		$('#create_stock').click(function(event) {
		    event.preventDefault();
		    $('#create_stock_modal').modal('show');
		});

		$('#create_supplier').click(function(event) {
		    event.preventDefault();
		    $('#create_supplier_modal').modal('show');
		});

		

		$.ajaxSetup( {
		    headers: {
		        'X-CSRF-TOKEN': $('meta[stock_type="csrf-token"]').attr('content'),
		        'X-CSRF-TOKEN': $('meta[stock_code="csrf-token"]').attr('content'),
		        'X-CSRF-TOKEN': $('meta[item_no="csrf-token"]').attr('content'),
		        'X-CSRF-TOKEN': $('meta[desc="csrf-token"]').attr('content'),
		        'X-CSRF-TOKEN': $('meta[unit="csrf-token"]').attr('content'),
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		        'X-CSRF-TOKEN': $('meta[stock_costs="csrf-token"]').attr('content')
		    }
		} );

		

		$('#store_supplier_form').submit(function( event ) {
		    event.preventDefault();
		    $.ajax({
		        url: '/store_supplier',
		        type: 'post',
		        data: $( this ).serialize(),
		    });
		    $('#create_supplier_modal').modal('hide');
		    fetch_supplier();
		});
		$('#store_stock_form').submit(function( event ) {
		    event.preventDefault();
		    $.ajax({
		        url: '/store_stock',
		        type: 'post',
		        data: $( this ).serialize(),
		    });
		    $('#create_stock_modal').modal('hide');
		});
		
		function fetch_supplier () {
			$('#supplier_select').empty();
			$.ajax({
			  url: "/fetch_supplier",
			  success: function( data ) {
			    parsed_data = $.parseJSON(JSON.stringify(data));
				$.each(parsed_data, function(key, val) {   
				   $('#supplier_select')
				        .append(
				        	$('<option>', { value : parsed_data[key].id })
				        					.text(parsed_data[key].name));
				});
			  }
			});
		}


	</script>
	@if ($check == 1)
	<div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
						<h1 class="page-header">Items To Be Received</h1>
						<div class="table-responsive">
							<table class="table table-stripped">
								<thead>
									<td>#</td>
									<td>Complete Code</td>
									<td>Description</td>
									<td>Quantity To Receive</td>
									<td>Unit Cost</td>
									<td>Total Cost</td>
									<td>Actions</td>
								</thead>
								<tbody>
										@foreach($to_be_received as $key => $stock_info)
											<tr>
												<td>{{ ++$key }}</td>
												<td>155-{{ $stock_info->stock->stock_type }}-{{ $stock_info->stock->stock_code }}-{{ $stock_info->stock->item_no }}</td>
												<td>{{ $stock_info->stock->desc }}</td>
												{!! Form::open(['route' => ['edit_to_receive', $stock_info->id], 'method' => 'POST']) !!}
												<td>{{ Form::text('quantity_received', $stock_info->quantity_received, ['class' => 'form-control', 'placeholder' => 'PLEASE FILL UP']) }}</td>
												<?php
															$stock_cost = Stock_Cost::where ('id', $stock_info->cost)->first()->unit_cost;
												?>
												<td>{{ $stock_cost }}</td>
												<td>{{ (float)$stock_cost * (float)$stock_info->quantity_received }}</td>
												<td>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                    {{ Form::submit('Edit', ['class' => 'btn btn-primary']) }}
                                                                {!! Form::close() !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::open(['route' => ['destroy_to_receive', $stock_info->id], 'method' => 'POST']) !!}
                                                                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                                                                {!! Form::close() !!}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
											</tr>
										@endforeach
								</tbody>
                            </table>
                            {!! Form::open (['action' => 'StockController@receive_stock_final', 'method' => 'POST']) !!}
                                {{ Form::submit ('Receive', ['class' => 'btn btn-success']) }}
                            {!! Form::close() !!}
						</div>
				</div>
	@endif
@endsection