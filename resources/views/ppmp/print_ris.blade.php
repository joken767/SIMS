<?php
    use App\Location;
    use App\Stock;
    use App\Stock_Cost;
    use App\Not_Yet;
?>
<style>
<?php include(public_path().'/css/bootstrap.css');?>
    #office{
        font: 15px Times New Roman;
    }
    #header{
        font: 20px Times New Roman !important;
        text-align: center;
    }
    table, th, tr, td, tbody{
        font: 12px Times New Roman;
        border: 1px solid black !important;
        text-align: center;
    }
</style>
    <p id="header"><b>REQUISITION AND ISSUE SLIP</b></p>
    <p id="office">Office  : <?php $loc = Location::where ('id', $location)->first()->loc_name; ?> <b> {{$loc}} </b></p>
    <p id="office">RIS NO : <b>{{$ris}}</b></p>
    <p id="office">Reference NO : <b>{{$ref}}</b></p>
    <table class="table">
        <thead>
            <tr>
            <th colspan="6"><b>Requisition</b></th>
            <th colspan="2"><b>Stock Available?</b></th>
            <th colspan="2"><b>Issue</b></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Stock No.</td>
                <td>Qty.</td>
                <td>Unit</td>
                <td>Desciption</td>
                <td>Unit Cost</td>
                <td>Total Cost</td>
                <td>Yes</td>
                <td>No</td>
                <td>Qty.</td>
                <td>Remarks</td>
            </tr>
            @foreach($data as $key => $result)
            <tr>
                <td> </td>
                <?php
                    $available = Stock_Cost::where ('stock_id', $result->stock_id)->first()->stock_available_cost;
                ?>
                <td>{{ $available }}</td>
                <?php
                    $unit = Stock::where ('id', $result->stock_id)->first()->unit;
                ?>
                <td>{{$unit}}</td>
                <?php
                    $stock_name = Stock::where ('id', $result->stock_id)->first()->desc;
                ?> 
                <td>{{$stock_name}}</td>
                <?php
                    $stock_cost = Stock_Cost::where ('stock_id', $result->stock_id)->first()->unit_cost;
                ?> 
                <td>{{$stock_cost}}</td>
                <td>{{$stock_cost*$available}}</td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
            @endforeach
        </tbody>
    </table>