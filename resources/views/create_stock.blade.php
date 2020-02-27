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
          <h1 class="page-header">Create Items</h1>
            <div class="panel panel-default">
			  <div class="panel-body">
			    <div class="row">
				  <div class="col-md-5">
				  	{!! Form::open (['action' => 'StockController@store_stock', 'method' => 'POST']) !!}
					    <div class="form-group">
						    {{ Form::label ('complete_code', 'Complete Code') }}
						    {{ Form::text ('complete_code', '', ['class' => 'form-control', 'placeholder' => 'WILL BE AUTOMATICALLY GENERATED', 'disabled']) }}
						  </div>
					  </div><!-- /.col-lg-6 -->
					  <div class="col-md-4">
					    <div class="form-group">
						    
						  </div>
					  </div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
					<div class="row">
					  <div class="col-lg-5">
					    <div class="form-group">
						    {{ Form::label ('stock_type', 'Stock Type') }}
						    {{ Form::text ('stock_type', '', ['class' => 'form-control', 'placeholder' => '']) }}
						  </div>
					  </div><!-- /.col-lg-6 -->
					  <div class="col-lg-4">
					    <div class="form-group">
						    
						  </div>
					  </div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
					<div class="row">
					  <div class="col-lg-5">
					    <div class="form-group">
						    {{ Form::label ('stock_code', 'Stock Code') }}
						    {{ Form::text ('stock_code', '', ['class' => 'form-control', 'placeholder' => '']) }}
						  </div>
					  </div><!-- /.col-lg-6 -->
					  <div class="col-lg-4">
					    <div class="form-group">
						    
						  </div>
					  </div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
					<div class="row">
					  <div class="col-lg-5">
					    <div class="form-group">
						    {{ Form::label ('item_no', 'Item Number') }}
						    {{ Form::text ('item_no', '', ['class' => 'form-control', 'placeholder' => '']) }}
						  </div>
					  </div><!-- /.col-lg-6 -->
					  <div class="col-lg-4">
					    <div class="form-group">
						    
						  </div>
					  </div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
					<div class="row">
					  <div class="col-lg-5">
					    <div class="form-group">
						    {{ Form::label ('desc', 'Description') }}
						    {{ Form::text ('desc', '', ['class' => 'form-control', 'placeholder' => '']) }}
						  </div>
					  </div><!-- /.col-lg-6 -->
					  <div class="col-lg-4">
					    <div class="form-group">
						    
						    <div class="input-group">
						    	
							</div>
						  </div>
					  </div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
					<div class="row">
					  <div class="col-lg-5">
					    <div class="form-group">
						    {{ Form::label ('unit', 'Unit') }}
						    {{ Form::text ('unit', '', ['class' => 'form-control', 'placeholder' => '']) }}
						  </div>
					  </div><!-- /.col-lg-6 -->
					  <div class="col-lg-4">
					    <div class="form-group">
						    
						  </div>
					  </div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
					<div class="row">
					  <div class="col-lg-5">
					    <div class="form-group">
						    {{ Form::label ('exp_date', 'Expiry Date') }}
						    {{ Form::date ('exp_date', null, ['class'=>'form-control']) }}
						  </div>
					  </div><!-- /.col-lg-6 -->
					  <div class="col-lg-4">
					    <div class="form-group">
						    
						  </div>
					  </div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
					<div class="row">
					  <div class="col-lg-8">
					    <div class="form-group">
						    
						  </div>
					  </div><!-- /.col-lg-6 -->
					  <div class="col-lg-5">
					    {{ Form::submit ('Create Item', ['class' => 'btn btn-success']) }}
					  </div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
				{!! Form::close () !!}
			  </div>
			  </div>
			</div>
        </div>
				@endif
@endsection