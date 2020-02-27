<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Supplier;
use App\Stock;
use App\Stock_Cost;
use App\Transaction;
use App\Receive;
use App\To_Be_Issued;
use App\Issue;
use DB;
use DateTime;
use Validator;
use App\User;
use App\To_Be_Received;
use App\Rand;
use App\Not_Yet;

use Barryvdh\DomPDF\Facade as PDF;

use App\Rules\threeChar;
use App\Rules\completeCode;
use App\Rules\available;
use App\Rules\duplicate;

class StockController extends Controller
{
    public function print_carried_stock ($id){
        $carried_on_stocks = [];
        $check = [];
        $transactions = Transaction::orderBy('transaction_date', 'DESC')->get();

        foreach ($transactions as $transaction) {
            if ($id >= $transaction->transaction_date) {
                if (!in_array ($transaction->stock_id, $check)) {
                    $check[] = $transaction->stock_id;
                    $carried_on_stocks[] = $transaction->id;
                }
            }
        }

        $stocks_carried = Transaction::whereIn('id', $carried_on_stocks)->get();
        
        // return view('/print_carried_stock', ['stocks_carried'=>$stocks_carried]);


        $year = $id[0].$id[1].$id[2].$id[3];
        $m = $id[5].$id[6];
        $month = DateTime::createFromFormat('!m', $m)->format('F');
        $day = $id[8].$id[9];
            
         $pdf = PDF::loadview('print_carried_stock', ['stocks' => $stocks_carried, 'year' => $year, 'month' => $month, 'day' => $day]);
         return $pdf->stream('test.pdf');

        //return view('/print_carried_stock', ['stocks' => $stocks_carried, 'year' => $year, 'month' => $month, 'day' => $day]);
    }
    public function print_issued_stocks (Request $request){
        //return $request;

        $from = $request->from;
        $to = $request->to;
        $version = $request->version;

        if($request->from > $request->to) {
            return "UNIDENTIFIED ERROR(s): <br><br>
            THE FROM DATE VALUE MUST BE BEFORE THE TO DATE VALUE<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        }

        $locations = Location::all();
        $stocks = Stock::all();

        $transactions = [];
        $pre_transactions = Transaction::orderBy ('transaction_date', 'DESC')->get ();

        foreach ($pre_transactions as $transaction) {
            if ($transaction->transaction_date <= $request->to && $transaction->transaction_date >= $request->from) {
                $transactions [] = $transaction;
            }
        }

        $issued_stocks = [];
        $pre_issued_stocks = Issue::orderBy ('date_issued', 'DESC')->get ();

        foreach ($pre_issued_stocks as $issued_stock) {
            if ($issued_stock->date_issued <= $request->to && $issued_stock->date_issued >= $request->from) {
                $issued_stocks [] = $issued_stock;
            }
        }

        //ag if dituy nu version 1, ket ilandscape tay pdf using dompdf nu met naan ket portrait
        if($request->version == 1){
            $pdf = PDF::loadview('print_issued_stocks', ['request' => $request, 'version' => $version, 'locations'=>$locations, 'stocks'=>$stocks,'transactions'=>$transactions, 'issued_stocks'=>$issued_stocks]);
             return $pdf->stream('issued_stocks.pdf');
        }else{
            $pdf = PDF::loadview('print_issued_stocks', ['request' =>$request, 'version' => $version, 'locations'=>$locations, 'stocks'=>$stocks,'transactions'=>$transactions, 'issued_stocks'=>$issued_stocks])->setPaper('Legal', 'Landscape');
             return $pdf->stream('issued_stocks.pdf');
        }

        // return view ('/print_issued_stocks')
        //     ->with('request', $request)
        //     ->with('locations', $locations)
        //     ->with('stocks', $stocks)
        //     ->with('transactions', $transactions)
        //     ->with('issued_stocks', $issued_stocks)
        //     ->with('from', $from)
        //     ->with('to', $to);

        // $pdf = PDF::loadview('print_issued_stocks', ['month' => $month, 'year' => $year, 'version' => $version, 'locations'=>$locations, 'stocks'=>$stocks, 
        //                     'transactions'=>$transactions, 'issued_stocks'=>$issued_stocks]);
        //  return $pdf->stream('test.pdf');

        // return view('print_issued_stocks', ['from' => $from, 'to' => $to, 'version' => $version, 'locations'=>$locations, 'stocks'=>$stocks, 
        //                     'transactions'=>$transactions, 'issued_stocks'=>$issued_stocks]);
    }
    
    public function fetch_uPrice ($id) {
        $stock_costs = Stock_Cost::where('stock_id', $id)->get();
        return $stock_costs;
    }

    public function fetch_location () {
        $locations = DB::table('locations')->orderBy('loc_name')->get();
        return $locations;
    }


    public function fetch_supplier () {
        $suppliers = DB::table('suppliers')->orderBy('name')->get();
        return $suppliers;
    }

    public function shit () {
        return view ('search_stock');
    }

    public function create_stock(){
        $suppliers = Supplier::orderBy ('name', 'ASC');

    	return view('/create_stock')->with ('suppliers', $suppliers);
    }

    public function store_stock (Request $request) {
        $validated_data = $request->validate ([
            'stock_type' => 'required',
            'stock_code' => 'required',
            'item_no' => 'required',
            'desc' => 'required',
            'unit' => 'required',
        ]);
        
        $stock = new Stock;

        $stock->user_id = auth ()->user ()->id;
        $stock->stock_type = $request->input ('stock_type');
        $stock->stock_code = $request->input ('stock_code');
        $stock->item_no = $request->input ('item_no');
        $stock->desc = $request->input ('desc');
        $stock->unit = $request->input ('unit');
        if ($request->has ('exp_date'))
            $stock->exp_date = $request->input ('exp_date');
        else
            $stock->exp_date = "0000-00-00";
            
        $stock->save ();

        return redirect ('/receive_stock');
    }

    public function issue_stock () {
        $locations = Location::orderBy ('loc_name', 'ASC');

        return view ('/issue_stock')->with ('locations', $locations);
    }

    public function issuing_stock (Request $request) {
        $validated_data = $request->validate ([
            'ris_no' => 'required',
            'date_issued' => 'required',
        ]);
        
        $locations = Location::all();

        return view ('/search_issue_stock')
            ->with('request', $request)
            ->with('locations', $locations);
    }

    public function issued_stock (Request $request) {
        $validator = Validator::make($request->all(), [
            'ris_no' => 'required',
            'location_id' => 'required',
            'date_issued' => 'required',
            'quantity_issued' => 'required',
            'stock_id' => 'required',
        ]);

        $stock = Stock::where ('id', $request->stock_id)->get()->first();
        $check = To_Be_Issued::where ('stock_id', $request->stock_id)->get()->first();

        if ($validator->fails() || $request->quantity_issued > $stock->total_stocks_available || $check != null) {
            return "UNIDENTIFIED ERROR(s): <br><br>
            EITHER YOU DID NOT ENTER ON ALL THE INPUT FIELDS<br>
            OR<br>
            YOU TRIED TO ISSUE A QUANTITY THAT IS CURRENTLY LARGER THAN THE TOTAL STOCKS AVAILABLE FOR THAT STOCK<br>
            OR<br>
            YOU ARE TRYING TO ISSUE AN ALREADY ISSUED STOCK IN THIS FORM<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        }
        
        $stock = Stock::where ('id', $request->stock_id)->get()->first();

        if(auth()->user()->type == 1) {
            $locations = Location::all();
        } else {
            $locations = Location::where('id', auth()->user()->location_id)->get();
        }
        $stock = Stock::where('id', $request->stock_id)->get()->first();

        if(auth()->user()->type == 1) {
            $toBeIssued = new To_Be_Issued;
            $toBeIssued->user_id = auth ()->user ()->id;
            $toBeIssued->stock_id = $request->stock_id;
            $toBeIssued->ris_no = $request->ris_no;
            $toBeIssued->date_issued = $request->date_issued;
            $toBeIssued->location_id = $request->location_id;
            $toBeIssued->quantity_issued = $request->quantity_issued;
            $toBeIssued->save();
        } else {
            $not_yet = new Not_Yet;
            $not_yet->user_id = auth ()->user ()->id;
            $not_yet->stock_id = $request->stock_id;
            $not_yet->ris_no = $request->ris_no;
            $not_yet->date_issued = $request->date_issued;
            $not_yet->location_id = $request->location_id;
            $not_yet->quantity_issued = $request->quantity_issued;
            $ref_no = Rand::where('location_id', auth()->user()->location_id)->first()->num;
            $not_yet->ref_no = (int)$ref_no;
            $not_yet->save();
        }

        return view('/issue_stock')
            ->with('request', $request)
            ->with('stock', $stock)
            ->with('locations', $locations);
    }

    public function issue_stock_final (Request $request) {
        $stocks_to_issue = To_Be_Issued::all();

        foreach ($stocks_to_issue as $stock_to_issue) {
            $oldest_price_received = Stock_Cost::where([
                ['stock_id', $stock_to_issue->stock_id],
                ['stock_available_cost', '>', 0]
            ])->orderBy('updated_at', 'ASC')->get();
            $temp_issue = $stock_to_issue->quantity_issued;

            foreach ($oldest_price_received as $opr) { 
                $temporary_cost = 0.00;
                $check = 0;
                 
                if ($opr->stock_available_cost >= $temp_issue) {
                    $transaction = new Transaction;

                    $transaction->transaction_date = $stock_to_issue->date_issued;
                    $transaction->stock_id = $stock_to_issue->stock_id;
                    $transaction->quantity_transacted = $temp_issue;
                    $transaction->cost_stock_at_hand = 0;
                    
                    $opr->stock_available_cost = (int)$opr->stock_available_cost - $temp_issue;
                    $temporary_cost += ((float)$opr->unit_cost * (float)$temp_issue);
                    $transaction->cost_quantity_transacted = $temporary_cost;
                    break;
                } else {
                    $transaction = new Transaction;

                    $transaction->transaction_date = $stock_to_issue->date_issued;
                    $transaction->stock_id = $stock_to_issue->stock_id;
                    $transaction->quantity_transacted = $opr->stock_available_cost;
                    $transaction->cost_stock_at_hand = 0;

                    $check = 1;
                    $temporary_cost += ((float)$opr->unit_cost * (float)$opr->stock_available_cost);
                    $transaction->cost_quantity_transacted = $temporary_cost;
                    $temp_issue -= $opr->stock_available_cost;
                    $opr->stock_available_cost = 0;

                    foreach ($oldest_price_received as $opr1) {
                        $opr1->save();
                    }
        
                    $transaction->transaction_type = 2;
        
                    $temp = 0;
        
                    foreach ($oldest_price_received as $opr1) {
                        $temp += $opr1->stock_available_cost;
                    }
        
                    $transaction->stock_at_hand = $temp;
        
                    if(!isset($transaction->cost_quantity_transacted)) {
                        return "ERROR";
                    }
        
                    $transaction->save();
        
                    $issue_info = new Issue;
        
                    $issue_info->user_id = auth()->user()->id;
                    $issue_info->stock_cost_id = $opr->id;
                    $issue_info->stock_id = $stock_to_issue->stock_id;
                    $issue_info->date_issued = $stock_to_issue->date_issued;
                    $issue_info->transaction_id = $transaction->id;
                    $issue_info->ris_no = $stock_to_issue->ris_no;
                    $issue_info->location_id = $stock_to_issue->location_id;
        
                    $issue_info->save();
        
                    $temp = 0;
                    foreach ($oldest_price_received as $opr) {
                        $temp += ((float)$opr->unit_cost * (float)$opr->stock_available_cost);
                    }
                    $transaction->cost_stock_at_hand = $temp;
        
                    $stock = Stock::where('id', $stock_to_issue->stock_id)->get()->first();
        
                    $stock->total_stocks_available = $transaction->stock_at_hand;
        
                    $stock->save();
        
                    $transaction->save();
                }
            }

            if ($check == 0) {
                foreach ($oldest_price_received as $opr1) {
                    $opr1->save();
                }
    
                $transaction->transaction_type = 2;
    
                $temp = 0;
    
                foreach ($oldest_price_received as $opr1) {
                    $temp += $opr1->stock_available_cost;
                }
    
                $transaction->stock_at_hand = $temp;
    
                if(!isset($transaction->cost_quantity_transacted)) {
                    return "ERROR";
                }
    
                $transaction->save();
    
                $issue_info = new Issue;
    
                $issue_info->user_id = auth()->user()->id;
                $issue_info->stock_cost_id = $opr->id;
                $issue_info->stock_id = $stock_to_issue->stock_id;
                $issue_info->date_issued = $stock_to_issue->date_issued;
                $issue_info->transaction_id = $transaction->id;
                $issue_info->ris_no = $stock_to_issue->ris_no;
                $issue_info->location_id = $stock_to_issue->location_id;
    
                $issue_info->save();
    
                $temp = 0;
                foreach ($oldest_price_received as $opr) {
                    $temp += ((float)$opr->unit_cost * (float)$opr->stock_available_cost);
                }
                $transaction->cost_stock_at_hand = $temp;
    
                $stock = Stock::where('id', $stock_to_issue->stock_id)->get()->first();
    
                $stock->total_stocks_available = $transaction->stock_at_hand;
    
                $stock->save();
    
                $transaction->save();
            }
        }

        foreach ($stocks_to_issue as $stocks_to_delete) {
            $stocks_to_delete->delete();
        }
        
        return redirect('/home');
    }

    public function receive_stock(){
        $suppliers = Supplier::orderBy ('name', 'ASC');

        return view('/receive_stock')->with ('suppliers', $suppliers);
    }

    public function receiving_stock (Request $request) {
        $validated_data = $request->validate ([
            'pr_no' => 'required',
            'date_received' => 'required',
        ]);
        
        return view('/search_receive_stock')->with ('request', $request);
    }

    public function search_stock (Request $request) {
        if(auth()->user()->type == 1) {
            $locations = Location::all();
        } else {
            $locations = Location::where('id', auth()->user()->location_id)->get();
        }
        /*
        if ($request->has('issued_stocks')) {
            return "1";
            $validator = Validator::make($request->all(), [
                //'search' => ['required', new completeCode],
                'search' => ['required', new threeChar],
            ]);

            if ($validator->fails()) {
                return "UNIDENTIFIED ERROR(s): <br><br>
                EITHER YOU DID NOT ENTER A SEARCH TERM<br>
                OR<br>
                YOU ENTERED A SEARCH TERM WITH LESS THAN 3 CHARACTERS<br><br>
                PLEASE CLICK THE BACK BUTTON.";
            }
            /*
            $search_pieces = explode ("-", $request->search);
            $results = Stock::where('stock_type', $search_pieces [1])
                ->where ('stock_code', $search_pieces [2])
                ->where ('item_no', $search_pieces [3])->get()->first();
            */
            /*
            $results = Stock::where('desc', 'LIKE', '%' . $request->search . '%')->get();
            $to_be_issued = To_Be_Issued::all();
            return view('/issued_stock')
                ->with('request', $request)
                ->with('results', $results)
                ->with('to_be_issued', $to_be_issued)
                ->with('locations', $locations);
    } else */if ($request->has('ris_no') || $request->has('issue')) {
            $validator = Validator::make($request->all(), [
                //'search' => ['required', new threeChar],
            ]);

            if ($validator->fails()) {
                return "UNIDENTIFIED ERROR(s): <br><br>
                EITHER YOU DID NOT ENTER A SEARCH TERM<br>
                OR<br>
                YOU ENTERED A SEARCH TERM WITH LESS THAN 3 CHARACTERS<br><br>
                PLEASE CLICK THE BACK BUTTON.";
            }
            /*
            $search_pieces = explode ("-", $request->search);
            $results = Stock::where('stock_type', $search_pieces [1])
                ->where ('stock_code', $search_pieces [2])
                ->where ('item_no', $search_pieces [3])->get()->first();
            */
            $results = Stock::where('desc', 'LIKE', '%' . $request->search . '%')->get();
            $stock_costs = Stock_Cost::where('id', $request->id);
            $ref_no = $request->ref_no;
            return view('/issue_stock')
                ->with('request', $request)
                ->with('results', $results)
                ->with('ref_no', $ref_no)
                ->with('locations', $locations);
        } else if ($request->has ('receive')) {            
            $validator = Validator::make ($request->all(), [
                'search' => ['required', new threeChar],
            ]);

            if ($validator->fails()) {
                return "UNIDENTIFIED ERROR(s): <br><br>
                EITHER YOU DID NOT ENTER A SEARCH TERM<br>
                OR<br>
                YOU ENTERED A SEARCH TERM WITH LESS THAN 3 CHARACTERS<br><br>
                PLEASE CLICK THE BACK BUTTON.";
            }
            $ref_no = $request->ref_no;
            $results = Stock::where ('desc', 'LIKE', '%' . $request->search . '%')->get ();
            return view ('receive_stock')
                ->with ('request', $request)
                ->with('ref_no', $ref_no)
                ->with ('results', $results);
        }        
    }

    public function edit_receive_stock (Request $request, $id) {
        $stock = Stock::where('id', $id)->get()->first();
        $suppliers = Supplier::orderBy ('name', 'ASC');
        $stock_costs = Stock_Cost::where('stock_id', $stock->id)->get();

        return view ('receive_stock')
            ->with('request', $request)
            ->with('stock', $stock)
            ->with ('suppliers', $suppliers)
            ->with('stock_costs', $stock_costs);
    }

    public function update_receive_stock (Request $request) {
        $validator = Validator::make($request->all(), [
            'stock_type' => 'sometimes|required',
            'stock_cost' => 'required',
            'stock_code' => 'sometimes|required',
            'pr_no' => 'required',
            'item_no' => 'sometimes|required',
            'po_no' => 'required',
            'desc' => 'sometimes|required',
            'supplier_id' => 'required',
            'unit' => 'sometimes|required',
            'date_received' => 'required',
            'quantity_received' => 'required',
            'stock_id' => 'required',
        ]);

        if ($validator->fails()) {
            return "UNIDENTIFIED ERROR(s): <br><br>
            YOU DID NOT ENTER AN INPUT ON ALL FIELDS<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        }

        $to_be_received = new To_Be_Received;
        $to_be_received->user_id = auth ()->user ()->id;
        $to_be_received->stock_id = $request->stock_id;
        $to_be_received->pr_no = $request->pr_no;
        $to_be_received->po_no = $request->po_no;
        $to_be_received->date_received = $request->date_received;
        $to_be_received->supplier_id = $request->supplier_id;
        $to_be_received->quantity_received = $request->quantity_received;
        $to_be_received->cost = (float)$request->stock_cost;
        $to_be_received->save ();

        $stock = Stock::where('id', $request->stock_id)->get()->first();
        $suppliers = Supplier::orderBy ('name', 'ASC');
        $stock_costs = Stock_Cost::where('stock_id', $stock->id)->get();

        return view ('receive_stock')
            ->with('request', $request)
            ->with('stock', $stock)
            ->with ('suppliers', $suppliers)
            ->with('stock_costs', $stock_costs);
    }

    public function receive_stock_final (Request $request) {
        $tbr = To_Be_Received::all ();

        foreach ($tbr as $to_be_received) {
            $stock = Stock::where ('id', $to_be_received->stock_id)->get()->first();
        
            $transaction_cost = Stock_Cost::where ('id', $to_be_received->cost)->first();
            $temp = 0.0;

            $transaction = new Transaction;
            
            $transaction->transaction_date = $to_be_received->date_received;
            $transaction->stock_id = $to_be_received->stock_id;
            $transaction->quantity_transacted = $to_be_received->quantity_received;
            $transaction->cost_quantity_transacted = (float)$to_be_received->quantity_received * (float)$transaction_cost->unit_cost;
            $transaction->transaction_type = 1;
            $transaction->stock_at_hand = (int)$stock->total_stocks_available + (int)$to_be_received->quantity_received; 
            $transaction->cost_stock_at_hand = 0;

            $stock = Stock_Cost::where('id', $to_be_received->cost)->first();
            $stock->stock_available_cost = (int)$stock->stock_available_cost + (int)$to_be_received->quantity_received;
            $stock->save();

            $transaction->save();

            $stock = new Receive;
            $stock->user_id = auth ()->user ()->id;
            $stock->stock_cost_id = $to_be_received->cost;
            $stock->date_received = $to_be_received->date_received;
            $stock->transaction_id = $transaction->id;
            $stock->po_no = $to_be_received->po_no;
            $stock->pr_no = $to_be_received->pr_no;
            $stock->supplier_id = $to_be_received->supplier_id;

            $stock->save();

            $stock = Stock::where('id', $to_be_received->stock_id)->first();

            $stock->total_stocks_available = (int)$stock->total_stocks_available + (int)$to_be_received->quantity_received;
            $stock->save();

            $stock_costs = Stock_Cost::where('stock_id', $to_be_received->stock_id)->get();
            foreach($stock_costs as $stock_cost) {
                //return $stock_cost->unit_cost;
                $temp += ((float)$stock_cost->unit_cost * (float)$stock_cost->stock_available_cost);
            }

            $transaction->cost_stock_at_hand = $temp;
            $transaction->save();
        }

        foreach ($tbr as $stocks_to_delete) {
            $stocks_to_delete->delete();
        }

        return redirect('/home');        
    }

    public function search_carried_stock (Request $request) {
        $validatedData = $request->validate([
            'date' => 'required',
        ]);
        
        $carried_on_stocks = [];
        $check = [];
        $transactions = Transaction::orderBy('transaction_date', 'DESC')->get();

        foreach ($transactions as $transaction) {
            if ($request->date >= $transaction->transaction_date) {
                if (!in_array ($transaction->stock_id, $check)) {
                    $check[] = $transaction->stock_id;
                    $carried_on_stocks[] = $transaction->id;
                }
            }
        }

        $stocks_carried = Transaction::whereIn('id', $carried_on_stocks)
        ->where ('stock_at_hand', '>', 0)->get();
        
        return view('/carried_stock')
            ->with('stocks_carried', $stocks_carried)
            ->with('dated', $request->date);
    }



    public function create_location () {
        return view ('/create_location');
    }

    public function store_location (Request $request) {
        $location = new Location;
        $location->loc_name = $request->input ('loc_name');
        $location->save ();

        return redirect ('/home');
    }

    public function create_supplier () {
        return view ('/create_supplier');
    }

    public function store_supplier (Request $request) {
        $supplier = new Supplier;
        $supplier->name = $request->input ('name');
        $supplier->save ();

        return redirect ('/create_supplier');
    }



    public function create_stock_cost ($id) {
        return view ('/create_stock_cost')->with('stock_id', $id);
    }

    public function store_stock_cost (Request $request) {
        $stock_cost = new Stock_Cost;

        $stock_cost->stock_id = $request->stock_id;
        $stock_cost->user_id = auth ()->user ()->id;
        $stock_cost->unit_cost = $request->stock_cost;
        $stock_cost->stock_available_cost = 0;

        $stock_cost->save();

        return redirect()->back();
    }

    public function edit_stock ($id) {
        $stock = Stock::where ('id', $id)->first ();
        $stock_costs = Stock_Cost::all ();
        $transactions = Transaction::where ('stock_id', $id)->orderBy ('transaction_date', 'DESC')->get ();
        
        return view ('/edit_stock')
            ->with ('stock', $stock)
            ->with ('stock_costs', $stock_costs)
            ->with ('transactions', $transactions);
    }

    public function update_stock (Request $request, $id) {
        $validatedData = $request->validate([
            'stock_type' => 'required',
            'stock_code' => 'required',
            'item_no' => 'required',
            'desc' => 'required',
            'unit' => 'required',
        ]);
        
        $stock = Stock::where ('id', $id)->get()->first();
            
        $stock->user_id = auth ()->user ()->id;
        $stock->stock_type = $request->input ('stock_type');
        $stock->stock_code = $request->input ('stock_code');
        $stock->item_no = $request->input ('item_no');
        $stock->desc = $request->input ('desc');
        $stock->unit = $request->input ('unit');
        $stock->exp_date = $request->input ('exp_date');
                
        $stock->save ();

        return redirect ('/home');
    }

    public function destroy_stock ($id) {
        $issues_to_delete = Issue::where ('stock_id', $id)->get ();
        $stock_to_delete = Stock::where ('id', $id)->first ();
        
        if (!empty ($issues_to_delete->first())) {
            foreach ($issues_to_delete as $itd) {
                $itd->delete ();
            }
        }
        
        $received_to_delete = Receive::all();

        foreach ($received_to_delete as $rtd) {
            $stock_costs = Stock_Cost::where ('id', $rtd->stock_cost_id)->get();
            
            foreach ($stock_costs as $cost) {
                if ($cost->stock_id == $id) {
                    $rtd->delete ();
                }
            }
        }

        foreach ($stock_to_delete->stock_costs as $cost) {
            $cost->delete ();
        }
        
        foreach ($stock_to_delete->transactions as $trans) {
            $trans->delete ();
        }

        $stock_to_delete->delete ();

        return redirect ('/home');
    }

    public function trace_stock () {
        $transactions = Transaction::orderBy ('transaction_date', 'DESC')->get ();

        return view ('/trace_stock')->with ('transactions', $transactions);
    }
    public function list_stock(){
        $stocks = Stock::orderBy('desc', 'ASC')->get();

        return view('/list_stock')->with('stocks', $stocks);
    }

    public function carried_stock(){
        $stocks_carried = null;

        return view('/carried_stock')->with('stocks_carried', $stocks_carried);
    }

    public function report_issued_stock () {
        $stocks = null;

        return view ('/report_issued_stock')->with('stocks', $stocks);
    }

    public function search_report_issued_stock (Request $request) {
        $validatedData = $request->validate([
            'from' => 'required',
            'to' => 'required',
        ]);

        if($request->from > $request->to) {
            return "UNIDENTIFIED ERROR(s): <br><br>
            THE FROM DATE VALUE MUST BE BEFORE THE TO DATE VALUE<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        }

        $locations = Location::all();
        $stocks = Stock::all();

        $transactions = [];
        $pre_transactions = Transaction::orderBy ('transaction_date', 'DESC')->get ();

        foreach ($pre_transactions as $transaction) {
            if ($transaction->transaction_date <= $request->to && $transaction->transaction_date >= $request->from) {
                $transactions [] = $transaction;
            }
        }

        $issued_stocks = [];
        $pre_issued_stocks = Issue::orderBy ('date_issued', 'DESC')->get ();

        foreach ($pre_issued_stocks as $issued_stock) {
            if ($issued_stock->date_issued <= $request->to && $issued_stock->date_issued >= $request->from) {
                $issued_stocks [] = $issued_stock;
            }
        }

        return view ('/report_issued_stock')
            ->with('request', $request)
            ->with('locations', $locations)
            ->with('stocks', $stocks)
            ->with('transactions', $transactions)
            ->with('issued_stocks', $issued_stocks);
    }




    public function edit_transaction ($id) {
        $transaction = Transaction::where ('id', $id)->first ();
        $locations = Location::orderBy ('loc_name', 'DESC');
        $suppliers = Supplier::orderBy ('name', 'DESC');
        
        return view ('/edit_transaction')
            ->with ('transaction', $transaction)
            ->with ('locations', $locations)
            ->with ('suppliers', $suppliers);
    }

    public function update_transaction (Request $request, $id) {
        $transaction_to_edit = Transaction::where ('id', $id)->first ();
        $transaction_latest_stock = Transaction::where ('stock_id', $transaction_to_edit->stock_id)
            ->orderBy ('transaction_date', 'DESC')
            ->orderBy ('created_at', 'DESC')->first ();
        
        if ($transaction_latest_stock == $transaction_to_edit) {
            if ($transaction_to_edit->transaction_type == 1) {
                $stock_to_save = Stock::where ('id', $transaction_to_edit->stock->id)->first ();
                (int)$stock_to_save->total_stocks_available -= (int)$transaction_to_edit->quantity_transacted;
                (int)$stock_to_save->total_stocks_available += (int)$request->quantity_transacted;
                $stock_to_save->save ();

                $stock_cost_to_edit = Stock_Cost::where ('id', $transaction_to_edit->incoming->first ()->stock_cost_id)->first ();
                (int)$stock_cost_to_edit->stock_available_cost -= (int)$transaction_to_edit->quantity_transacted;
                (int)$stock_cost_to_edit->stock_available_cost += (int)$request->quantity_transacted;
                $stock_cost_to_edit->save ();

                $incoming_to_edit = Receive::where ('id', $transaction_to_edit->incoming->first ()->id)->first ();
                $incoming_to_edit->user_id = auth ()->user ()->id;
                $incoming_to_edit->po_no = $request->po_no;
                $incoming_to_edit->pr_no = $request->pr_no;
                $incoming_to_edit->supplier_id = $request->supplier_id;
                $incoming_to_edit->save();

                (int)$transaction_to_edit->stock_at_hand -= (int)$transaction_to_edit->quantity_transacted;
                (int)$transaction_to_edit->stock_at_hand += (int)$request->quantity_transacted;
                $transaction_to_edit->quantity_transacted = $request->quantity_transacted;
                $cost = Stock_Cost::where ('id', $transaction_to_edit->incoming->first()->stock_cost_id)->first();
                $transaction_to_edit->cost_quantity_transacted = (float)$cost->unit_cost * (float)$request->quantity_transacted;
                $stock_costs = Stock_Cost::where('stock_id', $transaction_to_edit->stock_id)->get();
                $temp = 0.0;
                foreach($stock_costs as $stock_cost) {
                    $temp += ((float)$stock_cost->unit_cost * (float)$stock_cost->stock_available_cost);
                }
                $transaction_to_edit->cost_stock_at_hand = $temp;
                $transaction_to_edit->save();

                return redirect ('/home');
            } else {
                $stock_to_save = Stock::where ('id', $transaction_to_edit->stock->id)->first ();
                (int)$stock_to_save->total_stocks_available += (int)$transaction_to_edit->quantity_transacted;
                (int)$stock_to_save->total_stocks_available -= (int)$request->quantity_transacted;
                if ($stock_to_save->total_stocks_available < 0){
                    return "UNIDENTIFIED ERROR(s): <br><br>
                    THIS WILL RESULT IN A NEGATIVE VALUE FOR THE TOTAL STOCKS AVAILABLE<br><br>
                    PLEASE CLICK THE BACK BUTTON.";
                }
                $stock_to_save->save ();

                $stock_cost_to_edit = Stock_Cost::where ('id', $transaction_to_edit->outgoing->first ()->stock_cost_id)->first ();
                (int)$stock_cost_to_edit->stock_available_cost += (int)$transaction_to_edit->quantity_transacted;
                (int)$stock_cost_to_edit->stock_available_cost -= (int)$request->quantity_transacted;
               $stock_cost_to_edit->save ();

                $incoming_to_edit = Issue::where ('id', $transaction_to_edit->outgoing->first ()->id)->first ();
                $incoming_to_edit->ris_no = $request->ris_no;
                $incoming_to_edit->location_id = $request->location_id;
                $incoming_to_edit->save();

                (int)$transaction_to_edit->stock_at_hand += (int)$transaction_to_edit->quantity_transacted;
                (int)$transaction_to_edit->stock_at_hand -= (int)$request->quantity_transacted;
                $transaction_to_edit->quantity_transacted = $request->quantity_transacted;
                $cost = Stock_Cost::where ('id', $transaction_to_edit->outgoing->first()->stock_cost_id)->first();
                $transaction_to_edit->cost_quantity_transacted = (float)$cost->unit_cost * (float)$request->quantity_transacted;
                $stock_costs = Stock_Cost::where('stock_id', $transaction_to_edit->stock_id)->get();
                $temp = 0.0;
                foreach($stock_costs as $stock_cost) {
                    $temp += ((float)$stock_cost->unit_cost * (float)$stock_cost->stock_available_cost);
                }
                $transaction_to_edit->cost_stock_at_hand = $temp;
                $transaction_to_edit->save();

                return redirect ('/home');
            }
        } else {
            return "UNIDENTIFIED ERROR(s): <br><br>
            THIS WILL RESULT IN A NEGATIVE VALUE FOR THE TOTAL STOCKS AVAILABLE<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        }
    }

    public function destroy_transaction ($id) {
        $transaction_to_delete = Transaction::where ('id', $id)->first ();
        $transaction_latest_stock = Transaction::where ('stock_id', $transaction_to_delete->stock_id)
            ->orderBy ('transaction_date', 'DESC')
            ->orderBy ('created_at', 'DESC')->first ();        

        if ($transaction_latest_stock == $transaction_to_delete) {
            if ($transaction_to_delete->transaction_type == 1) {
                $stock_to_save = Stock::where ('id', $transaction_to_delete->stock->id)->first ();
                (int)$stock_to_save->total_stocks_available -= (int)$transaction_to_delete->quantity_transacted;
                $stock_to_save->save ();

                $stock_cost_to_edit = Stock_Cost::where ('id', $transaction_to_delete->incoming->first ()->stock_cost_id)->first ();
                (int)$stock_cost_to_edit->stock_available_cost -= (int)$transaction_to_delete->quantity_transacted;
                $stock_cost_to_edit->save ();

                $transaction_to_delete->incoming->first ()->delete ();
                $transaction_to_delete->delete ();

                return redirect ('/home');
            } else {
                $stock_to_save = Stock::where ('id', $transaction_to_delete->stock->id)->first ();
                (int)$stock_to_save->total_stocks_available += (int)$transaction_to_delete->quantity_transacted;
                $stock_to_save->save ();

                $stock_cost_to_edit = Stock_Cost::where ('id', $transaction_to_delete->outgoing->first ()->stock_cost_id)->first ();
                (int)$stock_cost_to_edit->stock_available_cost += (int)$transaction_to_delete->quantity_transacted;
                $stock_cost_to_edit->save ();

                $transaction_to_delete->outgoing->first ()->delete ();
                $transaction_to_delete->delete ();

                return redirect ('/home');
            }
        } else {
            return "UNIDENTIFIED ERROR(s): <br><br>
            THIS WILL RESULT IN A NEGATIVE VALUE FOR THE TOTAL STOCKS AVAILABLE<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        }
    }

    public function search_menu_stock (Request $request) {
        $validator = Validator::make ($request->all (), [
            'search' => ['required', new threeChar],
        ]);

        if ($validator->fails ()) {
            return "UNIDENTIFIED ERROR(s): <br><br>
            EITHER YOU DID NOT ENTER A SEARCH TERM<br>
            OR<br>
            YOU ENTERED A SEARCH TERM WITH LESS THAN 3 CHARACTERS<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        }

        $results = Stock::where ('desc', 'LIKE', '%' . $request->search . '%')->get ();
        
        return view ('search_menu_stock_result')->with ('results', $results);
    }

    public function edit_issue_stock (Request $request, $id) {
        if(auth()->user()->type == 1) {
            $locations = Location::all();
        } else {
            $locations = Location::where('id', auth()->user()->location_id)->get();
        }
        $stock = Stock::where('id', $id)->get ()->first ();
        $to_be_issued = To_Be_Issued::all();
        return view('/issue_stock')
            ->with('request', $request)
            ->with('stock', $stock)
            ->with('to_be_issued', $to_be_issued)
            ->with('locations', $locations);
    }

    public function edit_supplier ($id) {
        $supplier = Supplier::where ('id', $id)->get ()->first ();

        return view ('suppliers.edit')->with ('supplier', $supplier);
    }

    public function update_supplier (Request $request) {
        $supplier_to_edit = Supplier::where ('id', $request->id)->get ()->first ();
        $supplier_to_edit->name = $request->name;
        $supplier_to_edit->save ();

        return redirect ('/home');
    }

    public function destroy_supplier ($id) {
        $check = Receive::where ('supplier_id', $id)->get ();

        if (count ($check) >= 1) {
            return "UNIDENTIFIED ERROR(s): <br><br>
            THE SUPPLIER IS RELATED TO A TRANSACTION THEREFORE IT CAN'T BE DELETED<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        } else {
            $supplier_to_delete = Supplier::where ('id', $id)->get ()->first ();

            $supplier_to_delete->delete ();
        }

        return redirect ('/home');
    }

    public function list_location () {
        $locations = Location::orderBy ('loc_name', 'ASC')->get ();

        return view ('locations.index')->with ('locations', $locations);
    }

    public function edit_location ($id) {
        $location = Location::where ('id', $id)->get ()->first ();

        return view ('locations.edit')->with ('location', $location);
    }
    
    public function update_location (Request $request) {
        $location_to_edit = Location::where ('id', $request->id)->get ()->first ();
        $location_to_edit->loc_name = $request->loc_name;
        $location_to_edit->save ();

        return redirect ('/home');
    }

    public function destroy_location ($id) {
        $check = Issue::where ('location_id', $id)->get ();

        if (count ($check) >= 1) {
            return "UNIDENTIFIED ERROR(s): <br><br>
            THE LOCATION IS RELATED TO A TRANSACTION THEREFORE IT CAN'T BE DELETED<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        } else {
            $location_to_delete = Location::where ('id', $id)->get ()->first ();

            $location_to_delete->delete ();
        }

        return redirect ('/home');
    }

    public function create_location_account () {
        return "CREATE LOCATION ACCOUNT";
    }

    public function add_issue_stock(Request $request) {
        $not_yet = Not_Yet::where('ref_no', $request->search)->get();

        if(count($not_yet) > 0) {
            foreach($not_yet as $ny) {
                $toBeIssued = new To_Be_Issued;
                $toBeIssued->user_id = auth ()->user ()->id;
                $toBeIssued->stock_id = $ny->stock_id;
                $toBeIssued->ris_no = $ny->ris_no;
                $toBeIssued->date_issued = $ny->date_issued;
                $toBeIssued->location_id = $ny->location_id;
                $toBeIssued->quantity_issued = $ny->quantity_issued;
                $toBeIssued->ref_no = $ny->ref_no;
                $ny->delete();
                $toBeIssued->save();
            }
        }

        return view('/issue_stock')->with('request', $request);
    }

    public function edit_to_issue(Request $request, $id){
        
        if(auth()->user()->type == 1) {
            $to_be_issued = To_Be_Issued::where('id', $id)->first();
        } else {
            $to_be_issued = Not_Yet::where('id', $id)->first();
        }

        $to_be_issued->quantity_issued = $request->quantity_issued;

        $stock = Stock::where('id', $to_be_issued->stock_id)->first();
        if($request->quantity_issued > $stock->total_stocks_available || $request->quantity_issued == null) {
            return "UNIDENTIFIED ERROR(s): <br><br>
            EITHER YOU DID NOT ENTER ON ALL THE INPUT FIELDS<br>
            OR<br>
            YOU TRIED TO ISSUE A QUANTITY THAT IS CURRENTLY LARGER THAN THE TOTAL STOCKS AVAILABLE FOR THAT STOCK<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        }

        $to_be_issued->save();

        return view('/issue_stock');
    }

    public function destroy_to_issue($id){
        if(auth()->user()->type == 1) {
            $to_be_issued = To_Be_Issued::where('id', $id)->first();
        } else {
            $to_be_issued = Not_Yet::where('id', $id)->first();
        }
        
        $to_be_issued->delete();

        return view('/issue_stock');
    }

    public function edit_to_receive(Request $request, $id){
        
        $to_be_receive = To_Be_Received::where('id', $id)->first();
        $to_be_receive->quantity_received = $request->quantity_received;

        $stock = Stock::where('id', $to_be_receive->stock_id)->first();
        if($request->quantity_received == null) {
            return "UNIDENTIFIED ERROR(s): <br><br>
            EITHER YOU DID NOT ENTER ON ALL THE INPUT FIELDS<br><br>
            PLEASE CLICK THE BACK BUTTON.";
        }

        $to_be_receive->save();

        return view('/receive_stock');
    }

    public function destroy_to_receive($id){
        $to_be_issued = To_Be_Received::where('id', $id)->first();
        $to_be_issued->delete();

        return view('/receive_stock');
    }






    /*
    public function search_stock(){

    	$searched = request('search');
    	if($searched == ""){
    		return view('/home');
    	}else{
    		return view('/search_stock', ['value' => $searched]);	
    	}
    }
    */
    

    public function stock_details(){

    	$input = request('input');
    	$inp1 = "Molten Basketball G series";
    	return view('/stock_details', ['value' => $input , 'desc' => $inp1]);	
    }

    public function user(){

        return view('/user');
    }
}
