@extends("backend.layouts.layout")
@section("title", "Add New Media File | Phoenix")

@section("content")

<main class="main" id="top">
    @include("backend.layouts.sidebar")

    @livewire('media.add-new')
</main>

@endsection
