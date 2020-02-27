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
				
				<p><u><b>Inventory of Supplies & Materials Carried on Stock</b></u></p>
				<p>As of {{ $month." ".$day.", ".$year }}</p>
			</div>
		</div>
	</header>


	<table class="table table-bordered">
				<tr>
					<th>#</th>
					<th><b>Complete Code</b></th>
					<th><b>Description</b></th>
					<th><b>Unit Cost</b></th>
					<th><b>Unit</b></th>
					<th><b>Stocks On Hand</b></th>
					<th><b>Total Cost of Stock On Hand</b></th>
				</tr>
				<tbody>
					@if(!empty($stocks))
						@foreach($stocks as $key => $stock)
							<tr>
								<td>{{ ++$key }}</td>
								<td>155-{{ $stock->stock->stock_type }}-{{ $stock->stock->stock_code }}-{{ $stock->stock->item_no }}</td>
								<td>{{ $stock->stock->desc }}</td>
								<td>{{ $stock->stock->stock_costs->first()->unit_cost }}</td>
								<td>{{ $stock->stock->unit }}</td>
								<td>{{ $stock->stock_at_hand }}</td>
								<td>{{ $stock->cost_stock_at_hand }}</td>
								
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
</body>
</html>
	