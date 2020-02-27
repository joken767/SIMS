
<?php
  use App\Rand;

  if(Auth::user()->id != 1) {
    $rand = Rand::where('location_id', Auth::user()->location_id)->get();
    $same = 0;
    $rand_all = Rand::all();

    if(count($rand) > 0) {
      foreach($rand as $r) {
        $r->delete();
      }
    }

    while($same == 0) {
      $same = 1;
      $num = rand(1, 100);
      foreach($rand_all as $ra) {
        if ($ra->num == $num) {
          $same = 0;
        }
      }
    }
    
    $rand_new = new Rand;
    $rand_new->num = $num;
    $rand_new->location_id = Auth::user()->location_id;
    $rand_new->save();
  }
?>

@extends('layouts.app')

@section('content')
@include('layouts.dashboard.sidebar')
        @if (Auth::user ()->id == 1)
          <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Dashboard</h1>
              <h4>You are logged in</h4>
          </div>
        @endif
@endsection