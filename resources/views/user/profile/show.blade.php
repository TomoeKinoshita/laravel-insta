@extends('layouts.app')

@section('title', $user->name)  {{-- 「Profile」に代わってユーザー名を表示 --}}

@section('content')
    {{-- header --}}
    @include('user.profile.header')

    {{-- list of posts --}}
    <div class="mt-5">
        <div class="row">
            @forelse($user->posts as $post)  {{-- $user has many posts in User.php.  We can use this here --}}
                <div class="col-lg-4 col-md-6 mb-4">  {{-- make it adjustable by screen size--}}
                    <a href="{{ route('post.show', $post->id)}}">
                        <img src="{{ $post->image }}" alt="" class="grid-img">  {{-- "grid-img"は、style.cssより --}}
                    </a>
                </div>
                {{-- 新しいポストを画面左上から表示させたい。"->latest()"は、このファイルには書けない。書くには、User.php (User model)にて、public function posts中、return $this->hasMany(Post::class)->latest(); とする。 --}}

            @empty  {{-- if no posts --}}
                <h3 class="text-muted text-center">No posts yet.</h3>

            @endforelse
        </div>
    </div>

@endsection
