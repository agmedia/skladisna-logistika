@push('page_css')
    <style>

    </style>
@endpush

<ag-doc-block has-blocks="{{ (isset($blog) && ! empty($blog->blocks->groupBy('type')['pdf'])) ? $blog->blocks->groupBy('type')['pdf'] : '' }}"
              resource-id="{{ isset($blog) ? $blog->id : '' }}"
              image-size="3"
              delete-url="{{--{{ route('page.block.destroy') }}--}}"
></ag-doc-block>

@push('page_js')

@endpush
