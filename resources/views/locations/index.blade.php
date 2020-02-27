@extends('layouts.app')

@section('content')
    @include('layouts.dashboard.sidebar')
    @if (Auth::user ()->id == 1)
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">List of Offices</h1>
        <div class="table-responsive">
            <table class="table table-stripped">
                <thead>
                    <td>#</td>
                    <td>Office Name</td>
                    <td>Actions</td>
                </thead>
                <tbody>
                    @foreach($locations as $key => $location)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $location->loc_name }}</td>
                            <td>
                                <table>
                                    <tr>
                                        <td><a href="{{ url('/edit_location', $location->id) }}">{{ Form::submit ('Edit', ['class' => 'btn btn-primary']) }}</a></td>
                                        <td><a href="{{ url('/destroy_location', $location->id) }}">{{ Form::submit ('Delete', ['class' => 'btn btn-danger']) }}</a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection