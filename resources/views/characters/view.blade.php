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
        @if (!is_array($episodes))
            <p>{{ $episodes }}</p>
        @elseif (count($episodes) > 1)
            <ul>
                @foreach($episodes as $episode)
                    <li>{{ $episode->name }}</li>
                @endforeach
            </ul>
        @else
            <p>No appearances.</p>
        @endif
    @endisset
</div>
@endsection
