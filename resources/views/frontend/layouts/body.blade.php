@extends('frontend.layouts.app')

@section('body')

    @include('frontend.layouts.header')

    <main class="flex-shrink-0">
        <div class="container my-4">
            @include('frontend.embed.message')
            @yield('content')
        </div>
    </main>

    @include('frontend.layouts.footer')

@endsection
