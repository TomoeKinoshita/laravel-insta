@extends('layouts.app')

@section('title', $user->name. ' Followers')

@section('content')
    @include('user.profile.header')

    @if($user->followers->count() > 0)
        <div class="row justify-content-center">
            <div class="col-4">
                <h4 class="h4 text-muted text-center mb-3">Followers</h4>

                @foreach($user->followers as $follower)
                    <div class="row mb-2 align-items-center">
                        <div class="col-auto">  {{-- avatar, which is link --}}
                            <a href="{{ route('profile.show', $follower->follower->id) }}">
                                @if($follower->follower->avatar)
                                    <img src="{{ $follower->follower->avatar }}" alt="" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>

                        <div class="col ps-0 text-truncate">  {{-- name, also link --}}
                            <a href="{{ route('profile.show', $follower->follower->id) }}" class="text-decoration-none fw-bold text-dark">
                                {{ $follower->follower->name }}  {{-- see Follow model/User model. think which is inverse of the function --}}
                            </a>
                        </div>

                        <div class="col-auto">  {{-- follow button --}}
                            @if($follower->follower->id != Auth::user()->id)  {{-- != はNOTの意 --}}
                                @if($follower->follower->isFollowed())
                                    {{-- unfollow--}}
                                    <form action="{{ route('follow.destroy', $follower->follower->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 shadow-none text-muted">Following</button>
                                    </form>
                                @else
                                    {{-- follow --}}
                                    <form action="{{ route('follow.store', $follower->follower->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn p-0 shadow-none text-primary">Follow</button>
                                    </form>
                                @endif  {{-- logged-in userならボタン表示。なのでここには何も書かない。 --}}
                            @endif
                        </div>
                    </div>

                @endforeach
            </div>
        </div>


    @else
        <p class="h4 text-muted text-center">No followers yet.</p>
    @endif
@endsection
