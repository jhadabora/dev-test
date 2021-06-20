@extends('layouts.app')

@section('content')
<div class="container">
    @isset($characters)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($characters as $character)
                <tr>
                    <th scope="row">{{ $character->id }}</th>
                    <td><a href="{{ route('character', ['id' => $character->id]) }}"><img src="{{ $character->image }}" alt="Image of {{ $character->name }}" title="Image of {{ $character->name }}"></a></td>
                    <td><a href="{{ route('character', ['id' => $character->id]) }}">{{ $character->name }}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset
</div>
@endsection
