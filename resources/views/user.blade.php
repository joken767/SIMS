@extends('layouts.app')

@section('content')
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header">Inventory of Supplies and Materials Issued</h1>
		<div class="panel panel-default">
			  <div class="panel-body">

				<div class="row">
				  <div class="col-md-2">
				    <div class="form-group">
					    <label for="exampleInputEmail1">Month: </label>
					    <input type="text" class="form-control" name="completeCode">
					  </div>
				  </div><!-- /.col-lg-6 -->
				  <div class="col-md-2">
				    <div class="form-group">
					    <label for="exampleInputEmail1">Year: </label>
					    <input type="text" class="form-control" name="quantity">
					  </div>
				  </div><!-- /.col-lg-6 -->

				  <div class="col-lg-5">
				    <div class="form-group">
					    <label for="exampleInputEmail1">Version: </label>
					    <div class="input-group">
					    	<input type="text" class="form-control" name="supplier" value="New Version"><span class="input-group-addon" id="basic-addon0"><span class="caret"></span></span>
					    	<div class="col-lg-5">
				    	<button type="submit" class="btn btn-primary">Submit</button>
				  			</div><!-- /.col-lg-6 -->
						</div>
					  </div>
				  </div><!-- /.col-lg-6 -->
				</div><!-- /.row -->
			  </div>
			  </div>

			<button type="submit" class="btn btn-success">Print Document</button>
			</div>
@endsection