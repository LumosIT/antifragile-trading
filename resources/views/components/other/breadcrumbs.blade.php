<div class="mb-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    @foreach($items as $title => $link)

                        @if(is_string($title))
                            <li class="breadcrumb-item"><a href="{{ $link }}">{{ $title }}</a></li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ $link }}</li>
                        @endif

                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
</div>
