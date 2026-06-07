@extends('admin.layouts.app')

@section('content')
<div class="content-body">
    <div class="container-xxl">
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">الإعدادات</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="true">روابط التواصل</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">معلومات التواصل</button>
                            </li>
                        </ul>
                        <form method="POST" action="{{ route('admin.settings.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="tab-content pt-1" id="settingsTabContent">
                                <div class="tab-pane fade show active" id="social" role="tabpanel" aria-labelledby="social-tab">
                                    <div class="mb-1">
                                        <label class="form-label">رابط فيسبوك</label>
                                        <input type="url" class="form-control" name="facebook_link" value="{{ old('facebook_link', $settings->facebook_link ?? '') }}" placeholder="https://facebook.com/" />
                                        @error('facebook_link')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="mb-1">
                                        <label class="form-label">رابط انستغرام</label>
                                        <input type="url" class="form-control" name="instagram_link" value="{{ old('instagram_link', $settings->instagram_link ?? '') }}" placeholder="https://instagram.com/" />
                                        @error('instagram_link')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="mb-1">
                                        <label class="form-label">رابط تويتر</label>
                                        <input type="url" class="form-control" name="twitter_link" value="{{ old('twitter_link', $settings->twitter_link ?? '') }}" placeholder="https://twitter.com/" />
                                        @error('twitter_link')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="mb-1">
                                        <label class="form-label">رابط لينكدإن</label>
                                        <input type="url" class="form-control" name="linkedin_link" value="{{ old('linkedin_link', $settings->linkedin_link ?? '') }}" placeholder="https://linkedin.com/" />
                                        @error('linkedin_link')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="mb-1">
                                        <label class="form-label">بريد المرسل</label>
                                        <input type="email" class="form-control" name="sender_email" value="{{ old('sender_email', $settings->sender_email ?? '') }}" placeholder="example@domain.com" />
                                        @error('sender_email')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="mb-1">
                                        <label class="form-label">رقم الهاتف</label>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $settings->phone ?? '') }}" placeholder="+963 11 1234567" />
                                        @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="mb-1">
                                        <label class="form-label">العنوان</label>
                                        <textarea class="form-control" name="address" rows="3" placeholder="153 شارع الصناعة، المدينة الصناعية، سوريا">{{ old('address', $settings->address ?? '') }}</textarea>
                                        @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>

                                    <div class="mb-1">
                                        <label class="form-label">البريد الإلكتروني</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email', $settings->email ?? '') }}" placeholder="info@syluxbelgium.com" />
                                        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary">حفظ جميع الإعدادات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tabs properly
    var triggerTabList = [].slice.call(document.querySelectorAll('#settingsTabs button[data-bs-toggle="tab"]'));
    triggerTabList.forEach(function (triggerEl) {
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            
            // Remove active class from all tabs and panes
            document.querySelectorAll('#settingsTabs .nav-link').forEach(function(tab) {
                tab.classList.remove('active');
                tab.setAttribute('aria-selected', 'false');
            });
            
            document.querySelectorAll('#settingsTabContent .tab-pane').forEach(function(pane) {
                pane.classList.remove('show', 'active');
            });
            
            // Add active class to clicked tab
            triggerEl.classList.add('active');
            triggerEl.setAttribute('aria-selected', 'true');
            
            // Show corresponding pane
            var targetPane = document.querySelector(triggerEl.getAttribute('data-bs-target'));
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        });
    });
});
</script>


