@push('page_css')

@endpush

<div class="block block-rounded block-shadow">
    <div class="block-header block-header-default">
        <h3 class="block-title">Sekcija 5</h3>
    </div>
    <div class="block-content">
        <div class="row items-push py-4">
            <div class="col-lg-12">
                @if (isset($landing) && $landing->download_url != '')
                    <h6>Za Landing stranicu postoji ponuda u
                        <a href="{{ asset($landing->download_url) }}" download="{{ \Illuminate\Support\Str::slug($landing->client) }}">{{ \Illuminate\Support\Str::upper(substr($landing->download_url, -3)) }}</a>
                        formatu.
                        <span>
                            <button type="button" class="btn btn-sm btn-circle btn-alt-danger" data-toggle="tooltip" data-placement="top" title="Obriši snimljeni dokument" onclick="event.preventDefault();  shouldDeleteDoc({{ json_encode($landing) }});">
                                <i class="fa fa-times"></i>
                            </button>
                        </span>
                    </h6>
                @endif
                <p class="text-muted">Učitaj novu ponudu.</p>
                <hr>
                <div class="row mt-20">
                    <div class="col-12">
                        <label class="form-group mb-20 fileContainer">
                            <label for="pdf-file" id="pdf-file-name">Učitaj Ponudu</label>
                            <input type="file" onchange="setFile(event)" id="pdf-file" name="file" accept="application/pdf,application/zip">
                        </label>
                    </div>
                </div>
            </div>
            {{--<div class="col-lg-7 offset-lg-1">
                <div class="form-group mb-50">
                    <label for="pdf">Odaberi Ponudu</label>
                    <select class="form-control" id="pdf-select" name="pdf" style="width: 100%;">
                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                        @foreach ($pdfs as $pdf)
                            <option value="{{ 'media/' . $pdf }}" {{ (isset($landing) and (str_replace('media/', '', $landing->pdf) == $pdf)) ? 'selected' : '' }}>{{ str_replace('pdf/', '', $pdf) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>--}}
        </div>
    </div>
</div>

@push('page_js')
    <script>
        //$('#pdf-select').select2()

        function setFile(e) {
            let file = e.target.files[0]
            document.getElementById('pdf-file-name').innerHTML = file.name
        }

        function shouldDeleteDoc(landing) {
            confirmPopUp.fire({
                title: 'Are you sure?',
                text: 'Confirm deleting Landing Document: ' + landing.title,
                type: 'warning',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.value) {
                    deleteLandingDoc(landing)
                }
            })
        }

        function deleteLandingDoc(landing) {
            axios.post("{{ route('landing.destroy.doc') }}", {data: landing})
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
