@extends('frontend.layouts.app')

@section('title', __('Login'))

@section('content')

    <div class="container py-4">
        <div class="row align-content-center justify-content-center" style="height: 100vh">
            @guest
                <div class="col-md-4">
                    @include('frontend.includes.loginForm')
                </div>
            @else
                <div class="col-md-12">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Dashboard')
                        </x-slot>

                        <x-slot name="body">
                            @lang('You are logged in!')
                        </x-slot>
                    </x-frontend.card>
                </div>
            @endguest

            <!--col-md-8-->
        </div> <!-- row-->
    </div> <!-- container-->
@endsection
