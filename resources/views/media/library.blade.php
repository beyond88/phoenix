@extends('backend.layouts.sidebar')

@section('content')
<div class="container">
    <h1>Media Library</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($mediaItems as $media)
            <div class="col-md-3">
                <img src="{{ $media->getFirstMediaUrl('default') }}" alt="{{ $media->title }}" class="img-thumbnail">
                <p>{{ $media->title }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
