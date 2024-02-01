<div class="modal fade" id="delete-post-{{ $post->id }}">
                        {{-- make the ID unique --}}
    <div class="modal-dialog">
        <div class="modal-content border-danger">

            <div class="modal-header border-danger">
                <h4 class="modal-title h5 text-danger">
                    <i class="fa-solid fa-circle-exclamation"></i> Delete Post
                </h4>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
                <img src="{{ $post->image }}" alt="" class="img-lg mb-2 d-block">
                                                       {{-- img-lg from style.css --}}
                <p class="text-muted">{{ $post->description }}</p>
            </div>

            <div class="modal-footer border-0 text-end">
                <form action="{{ route('post.destroy', $post->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button>
                        {{-- type="button" doesn't submit. ordinary button--}}
                        {{-- data-bs-dismiss="modal" により、modal内のボタンで終了 --}}

                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        {{-- type="submit"により、formのaction=にて、delete formをsubmitできる。 --}}
                </form>
            </div>
        </div>
    </div>
</div>
