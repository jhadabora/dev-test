@extends('layouts.app')

@section('content')
<div class="container">
    @include('characters.filter')
    <h1>Characters</h1>

    @isset($characters)
        <nav aria-label="Results Navigation">
            <ul class="pagination">
                <li class="page-item {{ $page == 1 ? 'disabled' : '' }}"><a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}" {!! $page == 1 ? 'tabindex="-1"' : '' !!}>First</a></li>
                <li class="page-item {{ empty($info['prev']) ? 'disabled' : '' }}"><a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => max($page-1, 1)]) }}" {!! empty($info['prev']) ? 'tabindex="-1"' : '' !!}>Previous</a></li>
                @for ($i = max($page-5, 1); $i <= min($page+5, $info['pages']); $i++)
                    <li class="page-item {{ $i == $page ? 'active' : '' }}"><a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a></li>
                @endfor
                <li class="page-item {{ empty($info['next']) ? 'disabled' : '' }}"><a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => min($page+1, $info['pages'])]) }}" {!! empty($info['next']) ? 'tabindex="-1"' : '' !!}>Next</a></li>
                <li class="page-item {{ $page == $info['pages'] ? 'disabled' : '' }}"><a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $info['pages']]) }}" {!! $page == $info['pages'] ? 'tabindex="-1"' : '' !!}>Last</a></li>
            </ul>
        </nav>
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
