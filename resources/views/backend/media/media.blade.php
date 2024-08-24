@extends("backend.layouts.layout")
@section("title", "Media Library | Phoenix")
@section("content")
<main class="main" id="top">
    @include("backend.layouts.sidebar")

    @livewire('media.media')
</main>
@endsection