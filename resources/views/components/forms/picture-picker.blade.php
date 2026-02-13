@php($uniqueId = \Illuminate\Support\Str::uuid())
<label class="file-picker border border-1 d-flex align-items-center justify-content-center flex-column position-relative">
    <p class="text-muted">{{ $placeholder }}</p>
    <div class="w-100 h-100 position-absolute top-0 left-0" id="picker_preview_{{ $uniqueId }}" style="background-position:center;background-size: cover;">
    </div>
    <input type="file" accept=".jpeg,.jpg,.png" class="position-fixed" style="top:-100%;left:-100%;" id="picker_input_{{ $uniqueId }}" name="{{ $name }}">
    <div class="btn btn-white z-2">
        <i class="ri-pencil-line"></i>
    </div>
</label>

@push('styles')
    <style>
        .file-picker{
            width: 200px;
            height: 200px;
            display: block;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript">

        (function(){

            let $preview = $("#picker_preview_{{ $uniqueId }}");

            @isset($value)
                $preview.css('background-image', `url("{{$value}}")`)
            @endisset

            $("#picker_input_{{ $uniqueId }}").on('change', function(){

                let file = this.files[0];

                $preview.css('background-image', `url("${URL.createObjectURL(file)}")`);

            });

        })();

    </script>
@endpush
