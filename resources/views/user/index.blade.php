@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row gx-5">
    <div class="col-8">

        @if($search)  {{-- It searches if it's not null --}}
        <p class="h5 teaxt-muted mb-4">Search results for "<strong>{{ $search }}</strong>"</p>
        @endif

        {{-- posts --}}
        @forelse ($all_posts as $post)
            {{-- if there is no data, @empty (below) will be displayed. --}}
        <div class="card mb-4">
            {{-- title --}}
            @include('user.posts.contents.title')

            {{-- body --}}
            <div class="container p-0">
                <a href="{{ route('post.show', $post->id) }}">
                    <img src="{{ $post->image }}" alt="" class="w-100">
                </a>
            </div>

            <div class="card-body">
                @include('user.posts.contents.body')

                {{-- COMMENTS --}}
                @if($post->comments->count() > 0)  {{-- if the post has any comments--}}
                    <hr>
                @endif

                @foreach($post->comments->take(3) as $comment)  {{-- "take(3)"" gets only 3 items--}}
                    @include('user.posts.contents.comments.list-item')
                @endforeach

                @if($post->comments->count() > 3)
                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small mb-3">View all {{$post->comments->count()}} comments</a>
                @endif

                @include('user.posts.contents.comments.create')

            </div>

        </div>

        @empty
        {{-- no posts --}}
        <div class="text-center">
            <h2>Share Photos</h2>
            <p class="text-muted">When you share photos, they appear on your profile.</p>
            <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
        </div>

        @endforelse

    </div>

    <div class="col-4">
        {{-- user info --}}
        <div class="row mb-5 py-3 align-items-center bg-white shadow-sm rounded-3">
            <div class="col-auto">
                <a href="{{ route('profile.show', Auth::user()->id) }}">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="" class="rounded-circle avatar-md">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                    @endif
                </a>
            </div>
            <div class="col ps-0">
                <a href="{{ route('profile.show', Auth::user()->id) }}" class="text-decoration-none text-dark fw-bold">
                    {{ Auth::user()->name }}
                </a>
                <p class="text-muted">{{ Auth::user()->email }}</p>
            </div>
        </div>

        {{-- suggested users --}}
        @if(count($suggested_users) > 0)
            <div class="row mb-3">
                <div class="col">
                    <span class="text-secondary fw-bold">Suggestions For You</span>
                </div>
                <div class="col-auto">
                    <a href="" class="text-decoration-none fw-bold text-dark">
                        See all
                    </a>
                </div>
            </div>

            @foreach($suggested_users as $user)
                <div class="row mb-3 align-items-center">
                    <div class="col-auto">   {{--avatar, link--}}
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>

                    <div class="col text-truncate ps-0">  {{--name, also link--}}
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                            {{ $user->name }}
                        </a>
                    </div>

                    <div class="col-auto">  {{-- follow button --}}
                        <form action="{{ route('follow.store', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn p-0 text-primary shadow-none">Follow</button>
                        </form>
                    </div>
                </div>
            @endforeach

        @endif

    </div>
</div>

@endsection
