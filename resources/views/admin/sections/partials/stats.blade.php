<div class="row mb-2">
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ $stats['total'] }}</h2>
                    <p class="card-text">إجمالي الأقسام</p>
                </div>
                <div class="avatar bg-light-primary p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-layer-group text-primary font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ $stats['active'] }}</h2>
                    <p class="card-text">أقسام مفعلة</p>
                </div>
                <div class="avatar bg-light-success p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-check-circle text-success font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex align-items-start pb-0">
                <div>
                    <h2 class="fw-bolder mb-0">{{ $stats['inactive'] }}</h2>
                    <p class="card-text">أقسام غير مفعلة</p>
                </div>
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="fa-solid fa-pause-circle text-warning font-medium-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
