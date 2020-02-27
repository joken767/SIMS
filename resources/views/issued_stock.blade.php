
@extends ('layouts.app')

@section ('content')
	@include ('layouts.dashboard.sidebar')
    @if (Auth::user ()->id == 1)
	<div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
		<h1 class='page-header'>Issue Stock</h1>
		<div class='panel panel-default'>
			<div class='panel-body'>
				<div class='row'>
					<div class='col-lg-8'>		
					{!! Form::open (['action' => 'StockController@search_stock', 'method' => 'POST']) !!}
							<div class='form-group'>
								{{ Form::label ('search', 'Search: ') }}
                                {{ Form::text ('search', '', ['class' => 'form-control']) }}
							</div>
                    </div>
                    <?php
                    /*
                    //$postvalue=array("a","b","c");
                    $myArray = [];
                    //echo json_encode($postvalue);
                    //echo $issued_stocks[0]->id;
                    
                    

                    foreach($issued_stocks as $value)
                    {
                        
                        //echo '<input type="hidden" name="issued_stocks[]" value="'. $value->id. '">';
                        $myArray[] = json_encode($value->id);
                        //echo $value->id;
                    }

                  

                    foreach($myArray as $value)
                    {
                        echo '<input type="hidden" name="issued_stocks[]" value="'. $value. '">';
                    }
                    */
                    ?>
                    {{ Form::hidden('issued_stocks', 1) }}
                    {{ Form::hidden ('ris_no', $request->input('ris_no')) }}
					{{ Form::hidden ('location_id', $request->input('location_id')) }}
					{{ Form::hidden ('date_issued', $request->input('date_issued')) }}
                    <div class='col-lg-8'>
                            {{ Form::submit ('Search', ['class' => 'btn btn-success']) }}
                    </div>
					{!! Form::close () !!}
				</div>
			</div>
		</div>
    </div>

    <div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
            <div class='panel panel-default'>
                <div class='panel-body'>
                    <div class='row'>
                            {!! Form::open (['action' => 'StockController@issued_stock', 'method' => 'POST']) !!}
                            <div class="col-md-5">
                                    <div class="form-group">
                                        {{ Form::label('ris_no', 'RIS No') }}
                                        {{ Form::text('ris_no', '', ['class' => 'form-control', 'readonly']) }}
                                    </div>
                                </div>
                              <div class='col-md-4'>	
                                    <div class="form-group">
                                        {{ Form::label ('location_id', 'College/Office') }}
                                    <div class="input-group">
                                        {{ Form::select('location_id', $locations->pluck ('loc_name', 'id'), null, ['class'=>'form-control', 'readonly']) }}<span class="input-group-addon" id="basic-addon1"><a href="/create_location"><span class="glyphicon glyphicon-plus"></span></a></span>
                                    </div>
                                    </div>
                                </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    {{ Form::label ('date_issued', 'Date Issued') }}
                                {{ Form::date ('date_issued', null, ['class'=>'form-control', 'readonly']) }}
                                  </div>
                            </div><!-- /.col-lg-6 -->
                            <div class='col-lg-8'>
                                <div class='form-group'>
                                    <br/>
                                    <br/>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="from-group">
                                    {{ Form::label('complete_code', 'Complete Code') }}
                                    @if(!empty($results))
                                        {{ Form::text('complete_code', '155-' . $results->stock_type . '-' . $results->stock_code . '-' . $results->item_no, ['class' => 'form-control', 'disabled']) }}
                                    @else
                                        {{ Form::text('complete_code', null, ['class' => 'form-control', 'disabled']) }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="from-group">
                                    {{ Form::label('stock_type', 'Stock Type') }}
                                    @if(!empty($results))
                                        {{ Form::text('stock_type', $results->stock_type, ['class' => 'form-control', 'readonly']) }}
                                    @else
                                        {{ Form::text('stock_type', null, ['class' => 'form-control', 'disabled']) }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="from-group">
                                    {{ Form::label('stock_code', 'Stock Code') }}
                                    @if(!empty($results))
                                        {{ Form::text('stock_code', $results->stock_code, ['class' => 'form-control', 'readonly']) }}
                                    @else
                                        {{ Form::text('stock_code', null, ['class' => 'form-control', 'disabled']) }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="from-group">
                                    {{ Form::label('item_no', 'Item Number') }}
                                    @if(!empty($results))
                                        {{ Form::text('item_no', $results->item_no, ['class' => 'form-control', 'readonly']) }}
                                    @else
                                        {{ Form::text('item_no', null, ['class' => 'form-control', 'disabled']) }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="from-group">
                                    {{ Form::label('desc', 'Description') }}
                                    @if(!empty($results))
                                        {{ Form::text('desc', $results->desc, ['class' => 'form-control', 'readonly']) }}
                                    @else
                                        {{ Form::text('desc', null, ['class' => 'form-control', 'disabled']) }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="from-group">
                                    {{ Form::label('unit', 'Unit') }}
                                    @if(!empty($results))
                                        {{ Form::text('unit', $results->unit, ['class' => 'form-control', 'readonly']) }}
                                    @else
                                        {{ Form::text('unit', null, ['class' => 'form-control', 'disabled']) }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="from-group">
                                    {{ Form::label('quantity_issued', 'Quantity To Issue') }}
                                    @if(!empty($results))
                                        {{ Form::Number('quantity_issued', $results->quantity_issued, ['class' => 'form-control']) }}
                                    @else
                                        {{ Form::Number('quantity_issued', null, ['class' => 'form-control', 'disabled']) }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <br/>
                                @if(!empty($results))
                                    {{ Form::hidden('stock_id', $results->id) }}
                                    {{ Form::submit ('Submit', ['class' => 'btn btn-success']) }}
                                @endif
                            </div>
                            {!! Form::close () !!}         
                    </div>
                </div>
            </div>
				</div>

                @if (count ($to_be_issued) > 0)
				<div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
						<h1 class="page-header">Stocks To Be Issued</h1>
						<div class="table-responsive">
							<table class="table table-stripped">
								<thead>
									<td>#</td>
									<td>Complete Code</td>
									<td>Description</td>
									<td>Quantity</td>
								</thead>
								<tbody>
										@foreach($to_be_issued as $key => $stock_info)
											<tr>
												<td>{{ ++$key }}</td>
												<td>155-{{ $stock_info->stock->stock_type }}-{{ $stock_info->stock->stock_code }}-{{ $stock_info->stock->item_no }}</td>
												<td>{{ $stock_info->stock->desc }}</td>
												<td>{{ $stock_info->stock->total_stocks_available }}</td>
											</tr>
										@endforeach
								</tbody>
                            </table>
                            {!! Form::open (['action' => 'StockController@issue_stock_final', 'method' => 'POST']) !!}
                                {{ Form::submit ('Issue', ['class' => 'btn btn-success']) }}
                            {!! Form::close() !!}
						</div>
				</div>
            @endif
            @endif
@endsection







