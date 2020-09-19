@extends('back.layouts.backend')

@section('content')
    <div class="content">
        <h2 class="content-heading">Blogs
            <small>
                <span class="float-right">
                    <a href="{{ route('blog.create') }}" class="btn btn-sm btn-primary ml-30" data-toggle="tooltip" title="New">
                        <i class="si si-plus"></i> New Blog
                    </a>
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block">
            <div class="block-content">

                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th style="width: 30px;"></th>
                        <th>Name</th>
                        <th class="text-center" style="width: 15%;">Viewed</th>
                        <th class="text-center" style="width: 15%;">Status</th>
                        <th class="d-none d-sm-table-cell text-right" style="width: 20%;">Actions</th>
                    </tr>
                    </thead>
                    @foreach($blogs as $key => $blog)
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $key + 1 }}.</td>
                            <td class="font-w600">{{ $blog->title }}</td>
                            <td class="text-center pl-3">{{ $blog->viewed }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $blog->is_published ? 'success' : 'default' }}">{{ $blog->is_published ? 'Active' : 'Deactive' }}</span>
                            </td>
                            <td class="d-none d-sm-table-cell text-right">
                                <a href="{{ route('blog.edit', ['id' => $blog->id]) }}" class="btn btn-sm btn-outline-secondary js-tooltip-enabled" data-toggle="tooltip" data-title="Edit">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="event.preventDefault(); shouldDeleteBlog({{ json_encode($blog) }});">
                                    <i class="si si-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>

    </div>
@endsection

@push('js_after')
    <script>
      function shouldDeleteBlog(blog) {
        confirmPopUp.fire({
          title: 'Are you sure?',
          text: 'Confirm deleting Blog: ' + blog.title,
          type: 'warning',
          confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
          if (result.value) {
            deleteBlog(blog)
          }
        })
      }

      function deleteBlog(blog) {
        axios.post("{{ route('blog.destroy') }}", {data: blog})
          .then(r => {
            if (r.data) {
              successToast.fire({
                text: '',
              })

              location.reload()
            }
          })
          .catch(e => {
            errorToast.fire({
              text: e,
            })
          })
      }
    </script>
@endpush
