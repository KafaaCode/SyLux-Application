@extends('layouts.master')

@section('title', __('messages.contact_us'))

@section('content')
    <main id="content" class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white shadow rounded p-4">
                    <h1 class="mb-4 text-center">{{ __('messages.contact_us') }}</h1>
                    <p class="text-center mb-4">{{ __('messages.contact_intro') }}</p>

                    <form action="{{ route('support.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="sender_name" class="form-label">{{ __('messages.your_name') }}</label>
                            <input type="text" class="form-control" id="sender_name" name="sender_name"
                                placeholder="{{ __('messages.enter_name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="sender_email" class="form-label">{{ __('messages.your_email') }}</label>
                            <input type="email" class="form-control" id="sender_email" name="sender_email"
                                placeholder="{{ __('messages.enter_email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('messages.subject') }}</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="{{ __('messages.enter_subject') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">{{ __('messages.message') }}</label>
                            <textarea class="form-control" id="message" name="message" rows="5"
                                placeholder="{{ __('messages.enter_message') }}" required></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('messages.send_request') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection