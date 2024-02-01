<div class="modal fade" id="list-liker-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <div>
                <button type="button" data-bs-dismiss="modal" class="btn shadow-none float-end">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="my-5">

                @if($post->likes->count() > 0)

                    @foreach($post->likes as $like)
                        <div class="row my-2 mx-5 align-items-center">
                            <div class="col-auto">   {{--avatar, link--}}
                                <a href="{{ route('profile.show', $like->user->id) }}">
                                    @if($like->user->avatar)
                                        <img src="{{ $like->user->avatar }}" alt="" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                    @endif
                                </a>
                            </div>

                            <div class="col text-truncate ps-0">  {{--name, also link--}}
                                <a href="{{ route('profile.show', $like->user->id) }}" class="text-decoration-none text-dark fw-bold">
                                    {{ $like->user->name }}
                                </a>
                            </div>

                            <div class="col-auto">  {{-- follow button --}}
                                @if($like->user->id == Auth::user()->id)
                                    <br>
                                @elseif(!$like->user->isFollowed())
                                    <form action="{{ route('follow.store', $like->user->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn p-0 text-primary shadow-none">Follow</button>
                                    </form>
                                @else
                                    <form action="{{ route('follow.destroy', $like->user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 text-muted shadow-none">Unfollow</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
