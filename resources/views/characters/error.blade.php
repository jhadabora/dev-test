@extends('layouts.app')

@section('content')
<div class="container">
    @include('characters.filter')
    <h1>Characters</h1>

    @isset($alert)
        <div class="alert alert-danger">{{ $alert }}</div>
    @endisset
</div>
@endsection
