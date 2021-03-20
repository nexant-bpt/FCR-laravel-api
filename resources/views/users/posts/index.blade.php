@extends('layouts.app')

@section('content')

<div class="flex justify-center">
    <div class="w-8/12 bg-white p-6 rounded-lg">
        {{ $user->name }}
    </div>

    @if($posts->count())
    @foreach ($posts as $post)
        <x-post :post="$post" />
    @endforeach

    {{ $posts->links() }}
    @else
        <p>{{ $user->name }} Does not have any posts </p>
    @endif
</div>


@endsection