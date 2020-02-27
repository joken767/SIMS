<?php
	use App\To_Be_Issued;
	use App\Stock;
    use App\Stock_Cost;
    use App\Not_Yet;
    use App\Rand;
    
    $check = 0;

    if (auth()->user()->type == 1) {
        $to_be_issued = To_Be_Issued::all();
    } else {
        $rand = Rand::where('location_id', auth()->user()->location_id)->first()->num;
        $to_be_issued = Not_Yet::where('location_id', auth()->user()->location_id)
            ->where('ref_no', $rand)->get();
    }

    if (count ($to_be_issued) > 0) {
        $check = 1;
    }
?>

@extends('layouts.app')

@section('content')
	@include('layouts.dashboard.sidebar')
	<div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
		<h1 class='page-header'>Search Items to Issue</h1>
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
										@if (isset ($request->ris_no))
												{{ Form::hidden ('ris_no', $request->input('ris_no')) }}
												{{ Form::hidden ('location_id', $request->input('location_id')) }}
                                                {{ Form::hidden ('issue', true) }}
												{{ Form::hidden ('date_issued', $request->input('date_issued')) }}
                                                {{ Form::hidden ('ref_no', 'false') }}
											@else
												{{ Form::hidden ('issue', 'true') }}
                                                {{ Form::hidden ('ref_no', 'false') }}
											@endif
									</div>
								</div>
							</div>
							<div class='col-lg-5'>
								{{ Form::submit ('Submit', ['class' => 'btn btn-success']) }}
							</div>
						{!! Form::close () !!}
				</div>
                @if (Auth::user ()->id == 1)
                <br/>
                <div class="row">
                    <div class="col-md-5">
                        {!! Form::open (['action' => 'StockController@add_issue_stock', 'method' => 'POST']) !!}
                        <div class='form-group'>
								{{ Form::label ('search', 'Reference No: ') }}
								{{ Form::number ('search', '', ['class' => 'form-control']) }}
							</div>
					</div>
							<div class='row'>
								<div class='col-lg-8'>
									<div class='form-group'>
										@if (isset ($request->ris_no))
												{{ Form::hidden ('ris_no', $request->input('ris_no')) }}
												{{ Form::hidden ('location_id', $request->input('location_id')) }}
                                                {{ Form::hidden ('issue', true) }}
												{{ Form::hidden ('date_issued', $request->input('date_issued')) }}
                                                {{ Form::hidden('ref_no', 'true') }}
											@else
												{{ Form::hidden ('issue', 'true') }}
                                                {{ Form::hidden('ref_no', 'true') }}
											@endif
									</div>
								</div>
							</div>
							<div class='col-lg-5'>
								{{ Form::submit ('Add To Issue Cart', ['class' => 'btn btn-primary']) }}
							</div>
                        {!! Form::close () !!}
                    </div>
                </div>
                @endif
			</div>
		</div>
	</div>		
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
								{!! Form::open (['route' => ['issue_stock', $result->id], 'method' => 'GET']) !!}
									@if (isset ($request->ris_no))
										{{ Form::hidden ('ris_no', $request->input('ris_no')) }}
										{{ Form::hidden ('location_id', $request->input('location_id')) }}
										{{ Form::hidden ('date_issued', $request->input('date_issued')) }}
									@endif
									155-{{ $result->stock_type }}-{{ $result->stock_code }}-{{ $result->item_no }}
							</td>
                            <td>{{ $result->desc }}</td>
                            <td>{{ $result->total_stocks_available }}</td>
                            <td>{{ Form::submit ('Issue', ['class' => 'btn btn-primary']) }}</td>
                            {!! Form::close () !!}
                        </tr>
                        @endforeach
                    </tbody>
				</table>
				
            </div>
        </div>
	@endif
	@if(isset($stock))
	    <div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
            <h1 class="page-header">Item Information</h1>
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <div class='row'>
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('complete_code', 'Complete Code') }}
                                @if(!empty($stock))
                                    {{ Form::text('complete_code', '155-' . $stock->stock_type . '-' . $stock->stock_code . '-' . $stock->item_no, ['class' => 'form-control', 'disabled']) }}
                                @else
                                    {{ Form::text('complete_code', null, ['class' => 'form-control', 'disabled']) }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('total_stocks_available', 'Total Stocks Available') }}
                                @if(!empty($stock))
                                    {{ Form::text('total_stocks_available', $stock->total_stocks_available, ['class' => 'form-control', 'readonly']) }}
                                @else
                                    {{ Form::text('total_stocks_available', null, ['class' => 'form-control', 'disabled']) }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('stock_type', 'Stock Type') }}
                                @if(!empty($stock))
                                    {{ Form::text('stock_type', $stock->stock_type, ['class' => 'form-control', 'readonly']) }}
                                @else
                                    {{ Form::text('stock_type', null, ['class' => 'form-control', 'disabled']) }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('desc', 'Description') }}
                                @if(!empty($stock))
                                    {{ Form::text('desc', $stock->desc, ['class' => 'form-control', 'readonly']) }}
                                @else
                                    {{ Form::text('desc', null, ['class' => 'form-control', 'disabled']) }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('stock_code', 'Stock Code') }}
                                @if(!empty($stock))
                                    {{ Form::text('stock_code', $stock->stock_code, ['class' => 'form-control', 'readonly']) }}
                                @else
                                    {{ Form::text('stock_code', null, ['class' => 'form-control', 'disabled']) }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('unit', 'Unit') }}
                                @if(!empty($stock))
                                    {{ Form::text('unit', $stock->unit, ['class' => 'form-control', 'readonly']) }}
                                @else
                                    {{ Form::text('unit', null, ['class' => 'form-control', 'disabled']) }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                {{ Form::label('item_no', 'Item Number') }}
                                @if(!empty($stock))
                                    {{ Form::text('item_no', $stock->item_no, ['class' => 'form-control', 'readonly']) }}
                                @else
                                    {{ Form::text('item_no', null, ['class' => 'form-control', 'disabled']) }}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('exp_date', 'Expiry Date') }}
                                @if(!empty($stock))
                                    {{ Form::date('exp_date', $stock->exp_date, ['class' => 'form-control', 'readonly']) }}
                                @else
                                    {{ Form::date('exp_date', null, ['class' => 'form-control', 'disabled']) }}
                                @endif
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
		</div>


	    <div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
            <h1 class="page-header">Issue Information (Please Fill Up)</h1>
            <div class='panel panel-default'>
                <div class='panel-body'>
                    {!! Form::open (['action' => 'StockController@issued_stock', 'method' => 'POST']) !!}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    {{ Form::label('ris_no', 'RIS No') }}
                                    {{ Form::text('ris_no', '', ['class' => 'form-control', 'placeholder' => 'PLEASE FILL UP']) }}
                                </div>
                            </div>
                            <div class='col-md-4'>	
                                <div class="form-group">
                                    {{ Form::label ('location', 'College/Office') }}
                                    <div class="input-group">
                                        {{ Form::select('location_id', $locations->pluck ('loc_name', 'id'), null, ['class'=>'form-control', 'id'=>'location_id']) }}
                                            <span type="button" class="btn btn-primary input-group-addon btn-block" id="create_location">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    {{ Form::label ('date_issued', 'Date Issued') }}
                                    {{ Form::date ('date_issued', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('quantity_issued', 'Quantity To Be Issued') }}
                                    @if(!empty($stock))
                                        {{ Form::Number('quantity_issued', $stock->quantity_issued, ['class' => 'form-control', 'placeholder' => 'PLEASE FILL UP']) }}
                                    @else
                                        {{ Form::Number('quantity_issued', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'PLEASE FILL UP']) }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <br/>
                                @if(!empty($stock))
                                    {{ Form::hidden('stock_id', $stock->id) }}
                                    {{ Form::submit ('Add To Issue Cart', ['class' => 'btn btn-success']) }}
                                @endif
                            </div>  
                        </div>
                    {!! Form::close () !!}
                </div>
            </div>
		</div>
        <div class="modal fade" id="create_location_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 400px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>Details</h4> 
                    </div>
                    <div class="panel-body">
                        <div class='row'>
                            <div class='col-md-12'>
                                <form id="store_location_form" method="POST" action="{{ url('store_location') }}">
                                    <div class='form-group'>
                                        {{ Form::label ('loc_name', 'Location Name') }}
                                        {{ Form::text ('loc_name', '', ['class' => 'form-control', 'id' => 'location_name_field', 'required']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-md-3'>
                                    {{ Form::submit ('Add Location', ['class' => 'btn btn-success']) }}
                                    
                                </div>
                                {!! Form::close () !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">

            $('#create_location').click(function(event) {
                event.preventDefault();
                $('#create_location_modal').modal('show');
            });

            $.ajaxSetup( {
                headers: {
                    'X-CSRF-TOKEN': $('meta[loc_name="csrf-token"]').attr('content')
                }
            } );

            $('#store_location_form').submit(function( event ) {
                event.preventDefault();
                $.ajax({
                    url: '/store_location',
                    type: 'post',
                    data: $( this ).serialize(),
                });
                $('#create_location_modal').modal('hide');
                fetch_location();
            });

            function fetch_location () {
                $('#location_id').empty();
                $.ajax({
                  url: "/fetch_location",
                  success: function( data ) {
                    parsed_data = $.parseJSON(JSON.stringify(data));
                    $.each(parsed_data, function(key, val) {   
                       $('#location_id')
                            .append(
                                $('<option>', { value : parsed_data[key].id })
                                                .text(parsed_data[key].loc_name));
                    });
                  }
                });
            }

        </script>
	@endif
	@if ($check == 1)
				<div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
						<h1 class="page-header">Items To Be Issued</h1>
						<div class="table-responsive">
							<table class="table table-stripped">
								<thead>
									<td>#</td>
									<td>Complete Code</td>
									<td>Description</td>
									<td>Quantity to Issue</td>
									<td>Unit Cost</td>
									<td>Total Cost</td>
                                    <td>Actions</td>
								</thead>
								<tbody>
										@foreach($to_be_issued as $key => $stock_info)
											<tr>
												<td>{{ ++$key }}</td>
												<td>155-{{ $stock_info->stock->stock_type }}-{{ $stock_info->stock->stock_code }}-{{ $stock_info->stock->item_no }}</td>
												<td>{{ $stock_info->stock->desc }}</td>
                                                {!! Form::open(['route' => ['edit_to_issue', $stock_info->id], 'method' => 'POST']) !!}
												<td>{{ Form::text('quantity_issued', $stock_info->quantity_issued, ['class' => 'form-control', 'placeholder' => 'PLEASE FILL UP']) }}</td>
												<?php
															$stock_cost = Stock_Cost::where ('stock_id', $stock_info->stock_id)->first()->unit_cost;
												?>
												<td>{{ $stock_cost }}</td>
												<td>{{ (float)$stock_cost * (float)$stock_info->quantity_issued }}</td>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                    {{ Form::submit('Edit', ['class' => 'btn btn-primary']) }}
                                                                {!! Form::close() !!}
                                                            </td>
                                                            <td>
                                                                {!! Form::open(['route' => ['destroy_to_issue', $stock_info->id], 'method' => 'POST']) !!}
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
                            @if (Auth::user()->id == 1)
                            {!! Form::open (['action' => 'StockController@issue_stock_final', 'method' => 'POST']) !!}
                                {{ Form::submit ('Issue', ['class' => 'btn btn-success']) }}
                            {!! Form::close() !!}
                            @endif
						</div>
				</div>

    @endif
@endsection