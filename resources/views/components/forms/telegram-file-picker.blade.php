@php($hash = Str::uuid())
<div class="tg-picker border-1 border-opacity-50 rounded-2" id="{{ $hash }}">
    <div class="tg-picker-background">
        <video src="" class="tg-picker-video"></video>
        <img src="" class="tg-picker-photo" alt="">
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
        <a href="#" class="btn btn-warning btn-icon tg-picker-show" target="_blank">
            <i class="ri ri-eye-line"></i>
        </a>
    </div>
    <span class="label-btn-icon tg-picker-loader" style="display: none">
        <span class="spinner-border spinner-border-sm align-middle"></span>
    </span>
</div>

@if(!isset($no_initiate))
    @push('scripts')
    <script type="text/javascript">

        $("#{{ $hash }}").tgPicker({
            url : '{{ route('admin.api.files.upload') }}',
            getLink(file){
                return "{{ route('admin.api.files.get', '_var_1') }}".replace('_var_1', file.id);
            },
            @isset($file)
            value : @json($file)
            @endisset
        })

    </script>
    @endpush
@endif

