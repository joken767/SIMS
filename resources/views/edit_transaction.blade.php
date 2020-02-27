
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
					{!! Form::open (['route' => ['update_transaction', $transaction->id], 'method' => 'GET']) !!}
						<div class="row">
							<div class="col-md-5">      
					    	<div class="form-group">
						    	{{ Form::label ('quantity_transacted', 'Quantity Transacted') }}
						    	{{ Form::number ('quantity_transacted', $transaction->quantity_transacted, ['class' => 'form-control', 'placeholder' => '', 'min' => '0']) }}
						  	</div>
					  	</div>
                        @if ($transaction->transaction_type == 2)
                        <div class="col-md-4">
					    	<div class="form-group">
						    	{{ Form::label ('ris_no', 'RIS No') }}
						    	{{ Form::text ('ris_no', $transaction->outgoing->first()->ris_no, ['class' => 'form-control', 'placeholder' => '']) }}
						  	</div>
					  	</div>
						</div>
						<div class="row">
                        <div class="col-lg-5">
					    	<div class="form-group">
						    	{{ Form::label ('location_id', 'Location') }}
						    	{{ Form::select('location_id', $locations->pluck ('loc_name', 'id'), $transaction->outgoing->first()->location_id, ['class'=>'form-control']) }}
						  	</div>
					  	</div>
                          <div class="col-md-4">
					    	<div class="form-group">
						    	
						  	</div>
					  	</div>
						</div>
                        @else
                        <div class="col-md-4">
					    	<div class="form-group">
						    	{{ Form::label ('pr_no', 'PR No') }}
						    	{{ Form::text ('pr_no', $transaction->incoming->first()->pr_no, ['class' => 'form-control', 'placeholder' => '']) }}
						  	</div>
					  	</div>
						</div>
						<div class="row">
                          <div class="col-lg-5">
					    	<div class="form-group">
						    	{{ Form::label ('supplier_id', 'Supplier') }}
						    	{{ Form::select('supplier_id', $suppliers->pluck ('name', 'id'), $transaction->incoming->first()->supplier_id, ['class'=>'form-control']) }}
						  	</div>
					  	</div>
                          <div class="col-md-4">
					    	<div class="form-group">
                            {{ Form::label ('po_no', 'PO No') }}
						    {{ Form::text ('po_no', $transaction->incoming->first()->po_no, ['class' => 'form-control', 'placeholder' => '']) }}
						  	</div>
					  	</div>
						</div>
                        @endif
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
@endif
@endsection