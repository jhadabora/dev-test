@extends('layouts.app')

@section('content')
<div class="container">
    @isset($character)
        <h1>{{ $character->name }}</h1>
        <p><img src="{{ $character->image }}" alt="Image of {{ $character->name }}" title="Image of {{ $character->name }}"></p>
        <h2>Species</h2>
        <p>{{ $character->species }}</p>
        <h2>Origin</h2>
        <p>{{ $character->origin['name'] }}</p>
        <h2>Episode Appearances</h2>
        <p>{{ var_dump($character->episode) }}</p>
    @endisset
</div>
@endsection
