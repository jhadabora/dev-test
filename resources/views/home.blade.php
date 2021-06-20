@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Homepage</h1>
    <p><a href="{{ route('characters') }}">Click here to go to character search.</a></p>
    <p><span class="font-weight-bold">Time Spent: </span>2 hours 45 minutes</p>
</div>
@endsection
