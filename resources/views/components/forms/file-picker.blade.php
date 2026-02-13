@php($uniqueId = \Illuminate\Support\Str::uuid())
<div>
    <label class="btn btn-primary file-picker label-btn" id="file_picker_{{ $uniqueId }}">
        <i class="ri-file-3-fill label-btn-icon me-2"></i>
        <input type="file" accept="{{ $accept }}" name="{{ $name }}" style="position: fixed;left:100vw;top:100vh;">
        <span>{{ $placeholder }}</span>
    </label>
</div>


@push('styles')

    <style>
        .file-picker span{
            white-space: nowrap;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

@endpush

@push('scripts')
    <script type="text/javascript">

        (function(){

            $("#file_picker_{{ $uniqueId }} input").on('change', function(e) {

                $(this).next('span').text(this.files[0].name);

            })

        })();

    </script>
@endpush
