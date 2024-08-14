@extends('backend.layouts.sidebar')

@section('content')
<div class="container">
    <h1>Add New Media File</h1>

    <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="media">Select Media File</label>
            <input type="file" name="media" id="media" class="form-control-file" required>
        </div>

        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
