<?php
    use App\Stock;
    use App\To_Request;

    $shit = To_Request::all();
?>
@extends ('layouts.app')

@section ('content')
	@include ('layouts.dashboard.sidebar')
	    @if (Auth::user ()->id != 1)
        @if (count($shit) > 0)
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header">{{ $location->loc_name }} {{ $year }} PPMP REQUEST</h1>
		<div class="table-responsive">
			<table class="table table-stripped">
				<thead>
					<td colspan="3"><h2>1st Quarter</h2></td>
				</thead>
                <thead>
                    <td colspan="3"><h4>January</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($jan))
                        @foreach($jan as $j)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $j->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $j->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $j->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $j->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
                    <td colspan="3"><h4>February</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
                <tbody>
                    @if(isset ($feb))
                        @foreach($feb as $f)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $f->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $f->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $f->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $f->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
                    <td colspan="3"><h4>March</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($mar))
                        @foreach($mar as $mr)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $mr->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $mr->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $mr->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $mr->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
					<td colspan="3"><h2>2nd Quarter</h2></td>
				</thead>
                <thead>
                    <td colspan="3"><h4>April</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($apr))
                        @foreach($apr as $a)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $a->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $a->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $a->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $a->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
                    <td colspan="3"><h4>May</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($may))
                        @foreach($may as $my)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $my->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $my->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $my->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $my->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
                    <td colspan="3"><h4>June</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($jun))
                        @foreach($jun as $jn)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $jn->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $jn->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $jn->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $jn->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
					<td colspan="3"><h2>3rd Quarter</h2></td>
				</thead>
                <thead>
                    <td colspan="3"><h4>July</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($jul))
                        @foreach($jul as $jl)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $jl->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $jl->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $jl->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $jl->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
                    <td colspan="3"><h4>August</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($aug))
                        @foreach($aug as $ag)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $ag->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $ag->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $ag->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $ag->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
                    <td colspan="3"><h4>September</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($sep))
                        @foreach($sep as $s)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $s->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $s->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $s->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $s->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
					<td colspan="3"><h2>4th Quarter</h2></td>
				</thead>
                <thead>
                    <td colspan="3"><h4>October</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($oct))
                        @foreach($oct as $o)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $o->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $o->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $o->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $o->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
                    <td colspan="3"><h4>November</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($nov))
                        @foreach($nov as $n)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $n->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $n->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $n->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $n->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
                <thead>
                    <td colspan="3"><h4>December</h4></td>
                </thead>
                <thead>
                    <td>Stock</td>
                    <td>Amount Requested</td>
                    <td>Actions</td>
                </thead>
				<tbody>
                    @if(isset ($dec))
                        @foreach($dec as $d)
                            <tr>
                                <?php
                                    $stock = Stock::where('id', $d->stock_id)->first ();
                                ?>
                                <td>{{ $stock->desc }}</td>
                                <td>
                                    {!! Form::open (['route' => ['update_ppmp', $d->id], 'method' => 'POST']) !!}
                                        {{ Form::number ('amount_requested', $d->amount_requested, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                {{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}
                                                {!! Form::close () !!}
                                            </td>
                                            <td>
                                                {!! Form::open (['route' => ['destroy_ppmp', $d->id], 'method' => 'POST']) !!}
                                                    {{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}
                                                {!! Form::close () !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @endif
				</tbody>
			</table>
		</div>
	</div>
    @else
    <div class='col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main'>
                <h1 class='page-header'>You do not have a current ppmp request</h1>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        {!! Form::open (['action' => 'PPMPController@generate', 'method' => 'POST']) !!}
                            <div class='row'>
                                <div class='col-lg-8'>		
                                    <div class='form-group'>
                                        {{ Form::hidden ('year', date ("Y")) }}
                                    </div>
                                </div>
                                <div class='col-lg-8'>
                                    {{ Form::submit ('Generate PPMP Request', ['class' => 'btn btn-success']) }}
                                </div>
                            </div>
                        {!! Form::close () !!}
                    </div>
                </div>
            </div>
        @endif
        @endif
@endsection