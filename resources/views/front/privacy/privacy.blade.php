@extends('layouts.master')

@section('title', __('messages.privacy_policy'))

@section('content')
    <main id="content" role="main" class="container py-5">
        <div class="bg-white shadow rounded p-4">
            <h1 class="mb-4 text-center">{{ __('messages.privacy_policy') }}</h1>

            <p>{{ __('messages.intro', ['app' => config('app.name')]) }}</p>

            <h3 class="mt-4">{{ __('messages.collect_info') }}</h3>
            <p>{{ __('messages.collect_info_text') }}</p>

            <h3 class="mt-4">{{ __('messages.use_info') }}</h3>
            <p>{{ __('messages.use_info_text') }}</p>

            <h3 class="mt-4">{{ __('messages.share_info') }}</h3>
            <p>{{ __('messages.share_info_text') }}</p>

            <h3 class="mt-4">{{ __('messages.protect_info') }}</h3>
            <p>{{ __('messages.protect_info_text') }}</p>

            <h3 class="mt-4">{{ __('messages.user_rights') }}</h3>
            <p>{{ __('messages.user_rights_text') }}</p>

            <h3 class="mt-4">{{ __('messages.cookies') }}</h3>
            <p>{{ __('messages.cookies_text') }}</p>

            <h3 class="mt-4">{{ __('messages.children_privacy') }}</h3>
            <p>{{ __('messages.children_privacy_text') }}</p>

            <h3 class="mt-4">{{ __('messages.changes') }}</h3>
            <p>{{ __('messages.changes_text') }}</p>

            <h3 class="mt-4">{{ __('messages.contact_us') }}</h3>
            <p>{{ __('messages.contact_us_text') }}</p>
        </div>
    </main>
@endsection