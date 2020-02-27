<?php
	Use App\Stock_Cost;
?>
<!DOCTYPE html>
<html>
<head>
<style>
    <?php include(public_path().'/css/bootstrap.css');?>
    *{
    	font: 12px Times New Roman;
    }
    table, th, tr, td, tbody{
    	border: 1px solid black !important;
    }
    
    header {
    position: relative;
    width: 100%;
    min-height: auto;
    text-align: center;
 }

  header .header-content {
    position: relative;
    width: 100%;
 }

.header-content-inner img {
 position: absolute;
 top: 15px;
 left: 60px;  
 float: left; 
}
}

</style>

</head>
<body>
	<header>
	    <div class="header-content">
	    	<div class="header-content-inner">
				<p>MARIANO MARCOS STATE UNIVERSITY</p>
				<p>City of Batac 2906, Ilocos Norte</p>
				<p>SUPPLY AND PROPERTY MANAGEMENT OFFICE</p><br>
				
				<p><u><b>Reports of Supplies and Materials Issued</b></u></p>
				<p><b>From</b> <u><?php echo 	date('M d Y', strtotime($request->from)) ?></u>
				 <b>to</b> <u><?php echo 	date('M d Y', strtotime($request->to)) ?></u></p>
				
			</div>
		</div>
	</header>


@if(!empty($stocks))
	@if($request->version == 1)
				<table class="table table-stripped table-hover">
					<thead>
						<tr>
							<th><b>Total</b></th>
							<th><b>Description<b></th>
							@foreach($locations as $location)
								<th><b>{{ $location->loc_name }}</b></th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($stocks as $stock)
							<tr>
								<td>
									<?php
										$temp = 0;

										foreach ($transactions as $transaction) {
											if ($transaction->stock_id == $stock->id && $transaction->transaction_type == 2) {
												$temp += $transaction->quantity_transacted;
											}
										}
									?>
									{{ $temp }}
								</td>
								<td>{{ $stock->desc }}</td>
								@foreach ($locations as $key => $location)
									<?php
										$temp = 0;

										foreach ($transactions as $transaction) {
											foreach ($transaction->outgoing as $out) {
												if ($out->location_id == $location->id && $transaction->stock_id == $stock->id) {
													$temp += $transaction->quantity_transacted;
												}
											}
										}
									?>
									<td>{{ $temp }}</td>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
	@else
					<table class="table table-stripped table-hover">
						<thead>
							<tr>
								<th><b>PS</b></th>
								<th><b>RespCntrCode</b></th>
								<th><b>Complete Code</b></th>
								<th><b>Description</b></th>
								<th><b>Quantity Issued</b></th>
								<th><b>Unit Cost</b></th>
								<th><b>Total Cost</b></th>
							</tr>
						</thead>
						<tbody>
							@foreach($stocks as $stock)
								<tr>
									<td> </td>
									<td> </td>
									<td>155-{{ $stock->stock_type }}-{{ $stock->stock_code }}-{{ $stock->item_no }}</td>
									<td>{{ $stock->desc }}</td>
									<td>
										<?php
											$temp = 0;

											foreach ($transactions as $transaction) {
												if ($transaction->stock_id == $stock->id && $transaction->transaction_type == 2) {
													$temp += $transaction->quantity_transacted;
												}
											}
										?>
										{{ $temp }}
									</td>
									<td>
										<?php
											$stock_cost = Stock_Cost::where('stock_id', $stock->id)
												->orderBy('updated_at', 'DESC')->get();
											
											if(count($stock_cost) > 0) {
												$stock_cost = (float)$stock_cost->first()->unit_cost;
											} else {
												$stock_cost = 0.00;
											}
										?>
										{{ (float)$stock_cost }}
									</td>
									<td>
										<?php
											$total_cost = (float)$stock_cost * (float)$temp;
										?>
										{{ $total_cost }}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
	@endif
@endif
</body>
</html>
