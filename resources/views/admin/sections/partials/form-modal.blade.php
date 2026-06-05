<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(!empty($method))
                @method($method)
            @endif
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="{{ $modalId }}_name" class="form-label">اسم القسم <span class="text-danger">*</span></label>
                        <input type="text"
                               id="{{ $modalId }}_name"
                               name="name"
                               class="form-control"
                               value="{{ $name ?? '' }}"
                               placeholder="أدخل اسم القسم"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="{{ $modalId }}_image" class="form-label">صورة القسم</label>
                        <input type="file" id="{{ $modalId }}_image" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">PNG, JPG, WEBP — بحد أقصى 2MB</small>
                    </div>
                    @if(!empty($currentImage))
                        <div class="mt-1">
                            <img src="{{ asset('storage/' . $currentImage) }}" alt="صورة القسم" class="img-thumbnail" style="max-height: 80px;">
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-{{ $submitClass ?? 'primary' }}">{{ $submitLabel }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
