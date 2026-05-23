@extends('layouts.master')

@section('title', __('messages.about_us'))

@section('content')
    <main id="content" class="container py-5">
        <div class="bg-white shadow rounded p-5">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="mb-3">{{ __('messages.about_us') }}</h1>
                <p class="lead text-muted">{{ __('messages.about_intro') }}</p>
            </div>

            <!-- Our Mission -->
            <div class="mb-5">
                <h2 class="mb-3">{{ __('messages.our_mission') }}</h2>
                <p>{{ __('messages.mission_text') }}</p>
            </div>

            <!-- Our Vision -->
            <div class="mb-5">
                <h2 class="mb-3">{{ __('messages.our_vision') }}</h2>
                <p>{{ __('messages.vision_text') }}</p>
            </div>

            <!-- Our Values -->
            <div class="mb-5">
                <h2 class="mb-3">{{ __('messages.our_values') }}</h2>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi-check2-circle text-primary me-2"></i>{{ __('messages.value_quality') }}
                    </li>
                    <li class="mb-2"><i class="bi-check2-circle text-primary me-2"></i>{{ __('messages.value_trust') }}</li>
                    <li class="mb-2"><i class="bi-check2-circle text-primary me-2"></i>{{ __('messages.value_innovation') }}
                    </li>
                    <li class="mb-2"><i
                            class="bi-check2-circle text-primary me-2"></i>{{ __('messages.value_sustainability') }}</li>
                </ul>
            </div>

            <!-- Why Choose Us -->
            <div class="mb-5">
                <h2 class="mb-3">{{ __('messages.why_choose_us') }}</h2>
                <p>{{ __('messages.why_choose_text') }}</p>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-5">
                <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">{{ __('messages.contact_us') }}</a>
            </div>
        </div>
    </main>
@endsection