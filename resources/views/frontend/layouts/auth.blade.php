@extends('frontend.layouts.app')

@section('body')
    @include('frontend.layouts.header')

    <main class="flex-shrink-0">
        <div class="container my-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @include('frontend.embed.message')
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    @include('frontend.layouts.footer')
@endsection
