@extends('layouts.app')

@section('content')
	@include('layouts.dashboard.sidebar')
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="panel panel-default">
			  <div class="panel-body">
			    <div class="row">
				  <div class="col-md-5">
				    <div class="form-group">
					    <label for="exampleInputEmail1">Complete code: </label>
					    <input type="text" class="form-control" name="completeCode" value="<?=$value?>" disabled>
					  </div>
				  </div><!-- /.col-lg-6 -->
				  <div class="col-md-4">
				    <div class="form-group">
					    <label for="exampleInputEmail1">Unit: </label>
					    <input type="text" class="form-control" name="unit" value="piece">
					  </div>
				  </div><!-- /.col-lg-6 -->
				</div><!-- /.row -->

				<div class="row">
				  <div class="col-md-5">
				    <div class="form-group">
					    <label for="exampleInputEmail1">Stock type: </label>
					    <input type="text" class="form-control" name="stockType" value="001">
					  </div>
				  </div><!-- /.col-lg-6 -->
				  <div class="col-md-4">
				    <div class="form-group">
					    <label for="exampleInputEmail1">Description: </label>
					    <input type="text" class="form-control" name="description" value="<?=$desc?>">
					  </div>
				  </div><!-- /.col-lg-6 -->
				</div><!-- /.row -->

				<div class="row">
				  <div class="col-md-5">
				    <div class="form-group">
					    <label for="exampleInputEmail1">Stock Code: </label>
					    <input type="text" class="form-control" name="stockCode" value="0038">
					  </div>
				  </div><!-- /.col-lg-6 -->
				  <div class="col-md-4">
				    <div class="form-group">
					    <label for="exampleInputEmail1">Available Stock: </label>
					    <input type="text" class="form-control" name="availStock" value="8">
					  </div>
				  </div><!-- /.col-lg-6 -->
				</div><!-- /.row -->

				<div class="row">
				  <div class="col-md-5">
				    <div class="form-group">
					    <label for="exampleInputEmail1">Item number: </label>
					    <input type="text" class="form-control" name="itemNo" value="0021">
					  </div>
				  </div><!-- /.col-lg-6 -->
				  <div class="col-md-4">
				    <div class="form-group">
					    <input type="hidden" class="form-control" name="space">
					  </div>
				  </div><!-- /.col-lg-6 -->
				</div><!-- /.row -->

				<div class="row">
				  <div class="col-lg-8">
				    <div class="form-group">
					    <input type="hidden" class="form-control" name="space">
					  </div>
				  </div><!-- /.col-lg-6 -->

				  <div class="col-lg-5">
				    <button type="submit" class="btn btn-primary">Update Details</button>
				  </div><!-- /.col-lg-6 -->
				  
				</div><!-- /.row -->
			  </div>
			  </div>

			  <div class="table-responsive">
			  	<table class="table table-stripped">
			  		<thead>
			  			<tr>
			  				<th>Transaction Date</th>
			  				<th>Qty Received/Issued</th>
			  				<th>Unit Price</th>
			  				<th>RIS No.</th>
			  				<th>Received From/Issued To</th>
			  				<th>PO Number</th>
			  				<th>Onhand</th>
			  				<th>Transaction</th>
			  				<th>Action</th>
			  			</tr>
			  		</thead>
			  		<tbody>
			  			<tr>
			  				<td>2017-10-08</td>
			  				<td>10</td>
			  				<td>350</td>
			  				<td>10-17-058</td>
			  				<td>Mike's Department</td>
			  				<td>10-17-019-0001</td>
			  				<td>3</td>
			  				<td>Incoming</td>
			  				<td><button type="submit" class="btn btn-primary">Edit</button>&nbsp&nbsp<button type="submit" class="btn btn-warning">Delete</button></td>
			  			</tr>

			  			<tr>
			  				<td>2017-10-10</td>
			  				<td>1</td>
			  				<td>350</td>
			  				<td>10-17-058</td>
			  				<td>CAS</td>
			  				<td></td>
			  				<td>3</td>
			  				<td>Outgoing</td>
			  				<td><button type="submit" class="btn btn-primary">Edit</button>&nbsp&nbsp<button type="submit" class="btn btn-warning">Delete</button></td>

			  			</tr>
			  		</tbody>
			  	</table>
			  </div>
			</div>
@endsection