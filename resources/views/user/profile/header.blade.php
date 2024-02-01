<div class="row mb-5">
    <div class="col-4">
        {{-- icon/avatar --}}
        @if($user->avatar)
        <img src="{{ $user->avatar }}" alt="" class="img-thumbnail rounded-circle d-block mx-auto img-lg">

        @else
        <i class="fa-solid fa-circle-user icon-lg text-secondary d-block text-center"></i>
        @endif
    </div>

    <div class="col">
        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <h2 class="display-6 mb-0">{{ $user->name }}</h2>
                    {{-- $user is from ProfileController --}}
            </div>

            <div class="col">
                {{-- button depends on the user --}}
                @if($user->id == Auth::user()->id)
                    {{-- edit profile --}}
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary">Edit Profile</a>
                @else
                    {{-- follow --}}
                    @if($user->isFollowed())  {{--$user objectについてのfunctionなので、isFollowedはuser modelに書く--}}
                        {{-- unfollow --}}
                        <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Following</button>
                        </form>

                    @else
                        <form action="{{ route('follow.store', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Follow</button>
                        </form>
                    @endif
                @endif

            </div>
        </div>

        <div class="row mb-3">
            <div class="col-auto">
                <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{ $user->posts->count() }}</span> {{ $user->posts->count() ==1 ? 'post' : 'posts' }}
                                         {{-- here "posts" is array, not function. functionの場合、通常、posts()のように括弧がつく --}}
                    {{-- [if condition] ? [true] : [false] --}}
                    {{-- if statement in 1 line. short cut of display --}}
                </a>
            </div>

            <div class="col-auto">
                <a href="{{ route('profile.followers', $user->id) }}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{ $user->followers-> count() }}</span> {{ $user->followers->count() ==1 ? 'follower' : 'followers' }}
                </a>
            </div>

            <div class="col-auto">
                <a href="{{ route('profile.following', $user->id) }}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{ $user->follows->count() }}</span> following
                </a>
            </div>
        </div>

        <p class="fw-bold">
            {{ $user->introduction }}  {{-- "introduction" : column name of user table --}}
        </p>
    </div>
</div>
