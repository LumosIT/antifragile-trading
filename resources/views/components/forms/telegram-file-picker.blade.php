@php($hash = Str::uuid())
<div class="tg-picker border-1 border-opacity-50 rounded-2" id="{{ $hash }}">
    <div class="tg-picker-background">
        <span class="tg-picker-document">
            <i class="ri ri-file-3-fill"></i>
            <span>Выбран документ</span>
        </span>
    </div>
    <div class="tg-picker-buttons">
        <label class="btn btn-primary tg-picker-label me-2">
            <i class="ri ri-upload-2-fill fs-15"></i>
            {{ $placeholder }}
            <input type="file" class="tg-picker-input">
            <input type="hidden" name="{{ $name }}" class="tg-picker-value">
        </label>
    </div>
    <span class="label-btn-icon tg-picker-loader" style="display: none">
        <span class="spinner-border spinner-border-sm align-middle"></span>
    </span>
</div>

@if(!isset($no_initiate))
    @push('scripts')
    <script type="text/javascript">
        
    function renderPreview($picker, file) {
        $picker.find('.file-preview').remove();

        if (!file) return;

        let content = '';

        if (file.type === 'video') {
            content = `
                <video controls class="w-100">
                    <source src="${file.name}" type="video/mp4">
                </video>
            `;
        } else if (file.type === 'photo') {
            content = `
                <img src="${file.max_hash}">
            `;
        }

        let preview = `
            <div class="file-preview d-flex align-items-center justify-content-center overflow-hidden">
                ${content}
            </div>
        `;

        $picker.append(preview);
        let $showBtn = $picker.find('.tg-picker-show');

        if (file && file.type === 'video') {
            $showBtn.hide();
        } else {
            $showBtn.show();
        }
    }


    $("#{{ $hash }}").tgPicker({
        url : '{{ route('admin.api.files.upload') }}',
        getLink(file) {
            renderPreview($("#{{ $hash }}"), file);
            return "{{ route('admin.api.files.get', '_var_1') }}".replace('_var_1', file.id);
        },
        @isset($file)
        value : @json($file)
        @endisset
    });

    </script>
    @endpush
@endif

