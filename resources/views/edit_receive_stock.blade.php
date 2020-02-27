
@extends ('layouts.app')

@section ('content')
	@include ('layouts.dashboard.sidebar')
	@if (Auth::user ()->id == 1)
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Receive Stock</h1>
			  <div class="panel panel-default">
				<div class="panel-body">
				  <div class="row">
					<div class="col-md-5">
						{!! Form::open (['action' => 'StockController@update_receive_stock', 'method' => 'POST']) !!}
						  <div class="form-group">
							  {{ Form::label ('complete_code', 'Complete Code') }}
							  {{ Form::text ('complete_code', '155-' . $stock->stock_type . '-' . $stock->stock_code . '-' . $stock->item_no, ['class' => 'form-control', 'placeholder' => '', 'disabled']) }}
							</div>
						</div><!-- /.col-lg-6 -->
						<div class="col-md-4">
						  <div class="form-group">
							  {{ Form::label ('quantity', 'Total Stocks Available') }}
							  {{ Form::text ('quantity', $stock->total_stocks_available, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div><!-- /.col-lg-6 -->
					  </div><!-- /.row -->
					  <div class="row">
						<div class="col-lg-5">
						  <div class="form-group">
							  {{ Form::label ('stock_type', 'Stock Type') }}
							  {{ Form::text ('stock_type', $stock->stock_type, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div><!-- /.col-lg-6 -->
						<div class="col-lg-4">
						  <div class="form-group">
									{{ Form::label ('stock_cost', 'Unit Price') }}
									<div class="input-group">
										{{ Form::select('stock_cost', $stock_costs->pluck ('unit_cost', 'id'), null, ['class'=>'form-control']) }}<span class="input-group-addon" id="basic-addon1">
											<a href="{{ url('/create_stock_cost', $stock->id) }}"><span class="glyphicon glyphicon-plus"></span></a></span>
								</div>
							</div>
						</div><!-- /.col-lg-6 -->
					  </div><!-- /.row -->
					  <div class="row">
						<div class="col-lg-5">
						  <div class="form-group">
							  {{ Form::label ('stock_code', 'Stock Code') }}
							  {{ Form::text ('stock_code', $stock->stock_code, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div><!-- /.col-lg-6 -->
						<div class="col-lg-4">
						  <div class="form-group">
							  {{ Form::label ('pr_no', 'PR Number') }}
							  {{ Form::text ('pr_no', '', ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div><!-- /.col-lg-6 -->
					  </div><!-- /.row -->
					  <div class="row">
						<div class="col-lg-5">
						  <div class="form-group">
							  {{ Form::label ('item_no', 'Item Number') }}
							  {{ Form::text ('item_no', $stock->item_no, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div><!-- /.col-lg-6 -->
						<div class="col-lg-4">
						  <div class="form-group">
							  {{ Form::label ('po_no', 'PO Number') }}
							  {{ Form::text ('po_no', '', ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div><!-- /.col-lg-6 -->
					  </div><!-- /.row -->
					  <div class="row">
						<div class="col-lg-5">
						  <div class="form-group">
							  {{ Form::label ('desc', 'Description') }}
							  {{ Form::text ('desc', $stock->desc, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div><!-- /.col-lg-6 -->
						<div class="col-lg-4">
						  <div class="form-group">
							  {{ Form::label ('supplier_id', 'Supplier') }}
							  <div class="input-group">
								  {{ Form::select('supplier_id', $suppliers->pluck ('name', 'id'), null, ['class'=>'form-control', 'readonly']) }}<span class="input-group-addon" id="basic-addon1"><a href="/create_supplier"><span class="glyphicon glyphicon-plus"></span></a></span>
							  </div>
							</div>
						</div><!-- /.col-lg-6 -->
					  </div><!-- /.row -->
					  <div class="row">
						<div class="col-lg-5">
						  <div class="form-group">
							  {{ Form::label ('unit', 'Unit') }}
							  {{ Form::text ('unit', $stock->unit, ['class' => 'form-control', 'placeholder' => '', 'readonly']) }}
							</div>
						</div><!-- /.col-lg-6 -->
						<div class="col-lg-4">
						  <div class="form-group">
							  {{ Form::label ('date_received', 'Date Received') }}
							  {{ Form::date ('date_received', null, ['class'=>'form-control', 'readonly']) }}
							</div>
						</div><!-- /.col-lg-6 -->
					  </div><!-- /.row -->
					  <div class="row">
								<div class="col-lg-5">
									<div class="form-group">
										{{ Form::label ('quantity_received', 'Quantity To Be Received') }}
										{{ Form::number ('quantity_received', '', ['class' => 'form-control', 'placeholder' => 'PLEASE FILL THIS UP']) }}
									</div>
							</div><!-- /.col-lg-6 -->
					  </div>
					  <div class="row">
						<div class="col-lg-8">
						  <div class="form-group">
							  
							</div>
						</div><!-- /.col-lg-6 -->
						<div class="col-lg-5">
							{{ Form::hidden('stock_id', $stock->id) }}
						  {{ Form::submit ('Submit', ['class' => 'btn btn-primary']) }}
						</div><!-- /.col-lg-6 -->
					  </div><!-- /.row -->
				  {!! Form::close () !!}
				</div>
				</div>
			  </div>
		  </div>
			@endif
@endsection