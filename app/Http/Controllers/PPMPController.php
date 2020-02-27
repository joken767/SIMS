<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PPMP;
use App\User;
use App\To_Request;
use App\Not_Yet;
use App\Location;

use Barryvdh\DomPDF\Facade as PDF;

class PPMPController extends Controller
{
    public function print_ris(){
        $data = Not_Yet::all();
        $location = Not_Yet::first()->location_id;
        $ris = Not_Yet::first()->ris_no;
        $ref = Not_Yet::first()->ref_no;

        $pdf = PDF::loadview('ppmp.print_ris', ['data' => $data, 'location' =>$location, 'ris' => $ris, 'ref' => $ref]);
        return $pdf->stream('RISFORM.pdf');

        //return view('ppmp.print_ris', ['data' => $data, 'location' =>$location, 'ris' => $ris, 'ref' => $ref]);
    }
    public function create () {
        /*
        $ppmp = PPMP::where ('location_id', 1)
            ->where ('stock_id', 4)
            ->where ('month_requested', '03')
            ->orderBy ('amount_requested', 'ASC')->get ();
        
        $value = [];

        /*
        $value[] = 0;
        $value[] = 69;

        return $value[1];
        */
        /*
        $pastValue = 0.0;

        foreach ($ppmp as $key => $req) {
            if ($key++ == 0) {
                $value[] = (float)$req->amount_requested;
                $pastValue = (float)$req->amount_requested;
            } else {
                $pastValue = $value[] = $pastValue + 0.6 * ($req->amount_requested - $pastValue);
            }
        }

        $temp = 0.0;

        foreach ($value as $v) {
            $temp += $v;
        }

        return $temp /= count ($value);
        
        return (int)$value;
        */

        return view ('ppmp.create');
    }

    public function generate (Request $request) {
        $to_request_delete = To_Request::where('location_id', auth ()->user ()->location_id)->get();

        foreach ($to_request_delete as $trd) {
            $trd->delete();
        }

        $oldest_year = PPMP::where ('year_requested', '<', $request->year)
            ->where ('location_id', auth ()->user ()->location_id)
            ->orderBy ('year_requested', 'ASC')->get ();
        
        $stocks_to_check = [];

        foreach ($oldest_year as $a) {
            if (!in_array ($a->stock_id, $stocks_to_check)) {
                $stocks_to_check[] = (int)$a->stock_id;
            }
        }

        $year = [];
        $year[] = $oldest_year->first()->year_requested;
        $count = 0;

        while ($year[$count] != ($request->year) - 1) {
            $year[] = $year[$count] + 1;
            ++$count;
        }

        $months = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];

        foreach ($months as $m) {
            foreach ($stocks_to_check as $stock) {
                $amount_requested_stock = [];
                foreach ($year as $y) {
                    $check = 0;
                    foreach ($oldest_year as $ppmp) {
                        if ($ppmp->month_requested == $m) {
                            if ($stock == $ppmp->stock_id && $ppmp->year_requested == $y) {
                                $amount_requested_stock[] = (int)$ppmp->amount_requested;
                                $check = 1;
                                break;
                            }
                        }
                    }
                    if ($check == 0) {
                        $amount_requested_stock[] = 0;
                    }
                }
                sort($amount_requested_stock);
                $pastValue = (float)$amount_requested_stock[0];
                $value = [];

                foreach ($amount_requested_stock as $key => $ars) {
                    if ($key++ == 0) {
                        $value[] = (float)$ars;
                        $pastValue = (float)$ars;
                    } else {
                        $pastValue = $value[] = $pastValue + 0.6 * ($ars - $pastValue);
                    } 
                }

                $temp = 0.0;

                foreach ($value as $v) {
                    $temp += $v;
                }

                $forecasted_value = $temp / count ($value);

                $forecasted_value = round($forecasted_value);

                if ($forecasted_value > 0) {
                    $to_request = new To_Request;
                    $to_request->location_id = auth ()->user ()->location_id;
                    $to_request->stock_id = $stock;
                    $to_request->amount_requested = $forecasted_value;
                    $to_request->month_requested = $m;
                    if ($m == "01" || $m == "02" || $m == "03") {
                        $to_request->quarter_requested = 1;
                    } else if ($m == "04" || $m == "05" || $m == "06") {
                        $to_request->quarter_requested = 2;
                    } else if ($m == "06" || $m == "07" || $m == "08") {
                        $to_request->quarter_requested = 3;
                    } else {
                        $to_request->quarter_requested = 4;
                    }
                    $to_request->year_requested = $request->year;
                    $to_request->save();
                }
            }
        }

        return redirect ("/current_ppmp");
    }

    public function current () {
        $jan = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "01")->get ();
        $feb = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "02")->get ();
        $mar = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "03")->get ();
        $apr = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "04")->get ();
        $may = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "05")->get ();
        $jun = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "06")->get ();
        $jul = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "07")->get ();
        $aug = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "08")->get ();
        $sep = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "09")->get ();
        $oct = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "10")->get ();
        $nov = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "11")->get ();
        $dec = To_Request::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "12")->get ();
        $location = Location::where('id', auth ()->user ()->location_id)->first();
        $year = date ("Y");

        return view ('ppmp.current')
            ->with ('jan', $jan)
            ->with ('feb', $feb)
            ->with ('mar', $mar)
            ->with ('apr', $apr)
            ->with ('may', $may)
            ->with ('jun', $jun)
            ->with ('jul', $jul)
            ->with ('aug', $aug)
            ->with ('sep', $sep)
            ->with ('oct', $oct)
            ->with ('nov', $nov)
            ->with ('dec', $dec)
            ->with ('location', $location)
            ->with ('year', $year);
    }

    public function update (Request $request, $id) {
        $ppmp = To_Request::where ('id', $id)->first ();
        $ppmp->amount_requested = $request->amount_requested;
        $ppmp->save ();

        return redirect ("/current_ppmp");
    }

    public function destroy ($id) {
        $ppmp = To_Request::where ('id', $id)->first ();
        $ppmp->delete ();

        return redirect ("/current_ppmp");
    }

    public function past () {
        return view ('ppmp.past');
    }

    public function get_past (Request $request) {
        $validated_data = $request->validate ([
            'year' => 'required',
        ]);

        $ppmp = PPMP::where('year_requested', $request->year)->first();

        $jan = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "01")->where ('year_requested', $request->year)->get ();
        $feb = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "02")->where ('year_requested', $request->year)->get ();
        $mar = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "03")->where ('year_requested', $request->year)->get ();
        $apr = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "04")->where ('year_requested', $request->year)->get ();
        $may = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "05")->where ('year_requested', $request->year)->get ();
        $jun = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "06")->where ('year_requested', $request->year)->get ();
        $jul = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "07")->where ('year_requested', $request->year)->get ();
        $aug = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "08")->where ('year_requested', $request->year)->get ();
        $sep = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "09")->where ('year_requested', $request->year)->get ();
        $oct = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "10")->where ('year_requested', $request->year)->get ();
        $nov = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "11")->where ('year_requested', $request->year)->get ();
        $dec = PPMP::where ('location_id', auth ()->user ()->location_id)
            ->where ('month_requested', "12")->where ('year_requested', $request->year)->get ();
        $location = Location::where('id', auth ()->user ()->location_id)->first();
        $year = date ("Y");

        return view ('ppmp.past')
            ->with ('ppmp', $ppmp)
            ->with ('jan', $jan)
            ->with ('feb', $feb)
            ->with ('mar', $mar)
            ->with ('apr', $apr)
            ->with ('may', $may)
            ->with ('jun', $jun)
            ->with ('jul', $jul)
            ->with ('aug', $aug)
            ->with ('sep', $sep)
            ->with ('oct', $oct)
            ->with ('nov', $nov)
            ->with ('dec', $dec)
            ->with ('location', $location)
            ->with ('year', $year);
    }
}
