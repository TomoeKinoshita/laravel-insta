@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        {{-- 「enctype="multipart/form-data"」 allows the form to submit a file. --}}
        
    @csrf

    <p class="fw-bold">Category <span class="fw-light">(up to 3)</span></p>

    {{-- list of category check boxes --}}
    <div>
        @foreach($all_categories as $category)
                {{-- "$all_categories" is the list of categories that we have from PostController.php --}}
            <div class="form-check form-check-inline">
                <input type="checkbox" name="category_id[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input">
                <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
                    {{-- inputがいくつ現れるかわからない。ので、value="{{ $category->id }}"でセットして、name="category_id[]"の[ ]にてcategory_idを得る。 --}}

            </div>
        @endforeach
    </div>

    @error('category_id')
        <div class="text-danger small">{{ $message }}</div>
    @enderror


    <label for="description" class="form-label fw-bold mt-3">Description</label>
    <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{ old('description') }}</textarea>

    @error('description')
        <div class="text-danger small">{{ $message }}</div>
    @enderror


    <label for="image" class="form-label fw-bold mt-3">Image</label>
    <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
        {{-- aria-describedby は、オブジェクトを説明する要素の id を列挙する --}}
    <p class="form-text" id="image-info">
        Acceptable formats:jpeg, jpg, png, gif only <br>
        Max size is 1048 KB
    </p>

    @error('image')
        <div class="text-danger small">{{ $message }}</div>
    @enderror


    <button type="submit" class="btn btn-primary mt-4 px-4">Post</button>

</form>

@endsection
