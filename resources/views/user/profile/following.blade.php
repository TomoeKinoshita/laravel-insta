@extends('layouts.app')

@section('title', $user->name. ' Following')

@section('content')
    @include('user.profile.header')

    @if($user->follows->count() > 0)  {{-- check first if the user hasMany follows --}}
        <div class="row justify-content-center">
            <div class="col-4">
                <h4 class="h4 text-muted text-center mb-3">Following</h4>

                @foreach($user->follows as $follow)
                    <div class="row mb-2 align-items-center">
                        <div class="col-auto">  {{-- avatar, link --}}
                            <a href="{{ route('profile.show', $follow->followed->id) }}">
                                @if($follow->followed->avatar)
                                    <img src="{{ $follow->followed->avatar }}" alt="" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>

                        <div class="col ps-0 text-truncate">  {{-- name, also link --}}
                            <a href="{{ route('profile.show', $follow->followed->id) }}" class="text-decoration-none fw-bold text-dark">
                                {{ $follow->followed->name }}  {{-- see Follow model/User model. think which is inverse of the function --}}
                            </a>
                        </div>

                        <div class="col-auto">  {{-- follow button --}}
                            @if($follow->followed->id != Auth::user()->id)  {{-- 「!=」はNOTの意 --}}
                            {{-- only display a button if it's NOT logged-in user. --}}
                            {{-- if it's NOT logged-in user, then we have a button. If it IS logged-in user, then nothing. we don't have to add "else". --}}

                                @if($follow->followed->isFollowed())
                                    {{-- if the followed user isFollowed by logged-in user, --}}

                                    {{-- unfollow--}}
                                    <form action="{{ route('follow.destroy', $follow->followed->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 shadow-none text-muted">Following</button>
                                    </form>
                                @else
                                    {{-- follow --}}
                                    <form action="{{ route('follow.store', $follow->followed->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn p-0 shadow-none text-primary">Follow</button>
                                    </form>
                                @endif
                            @endif  {{-- logged-in userなら、ボタンなし。なのでここには何も書かない。 --}}
                        </div>
                    </div>

                @endforeach
            </div>
        </div>

    @else
        <p class="h4 text-muted text-center">Not following anyone yet.</p>
    @endif
@endsection
