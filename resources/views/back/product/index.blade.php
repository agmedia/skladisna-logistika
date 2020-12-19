@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
@endpush

@section('content')

    <div class="content">
        <h2 class="content-heading">Proizvodi
            <small>
                <span class="pl-2">({{ $products->total() }})</span>
                <span class="float-right">
                    <a href="{{ route('product.create') }}" class="btn btn-sm btn-secondary ml-30" data-toggle="tooltip" title="New Product">
                        <i class="si si-plus mr-5 text-info"></i> Novi Proizvod
                    </a>
                </span>
            </small>
        </h2>

        @include('back.layouts.partials.session')

        <div class="block" id="ag-autocomplete-app">
            <div class="block-content bg-body-light">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <ag-autocomplete url="{{ route('products.autocomplete') }}" min="1" target="products" placeholder="Upiši artikl koji tražiš..."></ag-autocomplete>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <form action="{{ route('products') }}" method="get">
                            <div class="form-group">
                                <select class="form-control" id="category-select" name="category">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}" {{ ($category['id'] == request()->input('category')) ? 'selected' : '' }}>{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-3">
                        <form action="{{ route('products') }}" method="get">
                            <div class="form-group">
                                <select class="form-control" id="manufacturer-select" name="manufacturer">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach ($manufacturers as $key => $manufacturer)
                                        <option value="{{ $key }}" {{ ($key == request()->input('manufacturer')) ? 'selected' : '' }}>{{ $manufacturer }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-1">
                        <div class="form-group">
                            <div class="dropdown float-right">
                                <button type="button" class="btn btn-secondary dropdown-toggle" id="products-status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Status
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="products-status" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(48px, 31px, 0px);">
                                    <button class="dropdown-item" onclick="SelectStatus('on')">
                                        <i class="fa fa-fw fa-star text-success mr-5"></i>Aktivni
                                    </button>
                                    <button class="dropdown-item" onclick="SelectStatus('off')">
                                        <i class="fa fa-fw fa-warning text-danger mr-5"></i>Deaktivirani
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item active" onclick="SelectStatus('all')">
                                        <i class="fa fa-fw fa-circle-o text-info mr-5"></i>Svi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search -->

                <!-- END Search -->
            </div>

            <div class="block-content">
                <div class="table-responsive">
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 108px;">SKU</th>
                        <th class="text-center" style="width: 81px;">Status</th>
                        <th>Ime Proizvoda</th>
                        <th class="text-center" style="width: 20%;">Kategorije</th>
                        <th class="text-center" style="width: 63px;">Kol.</th>
                        <th class="text-right" style="width: 108px;">Cijena</th>
                        <th class="text-center" style="width: 60px;"></th>
                    </tr>
                    </thead>
                    @foreach($products as $key => $product)
                        <tbody>
                        <tr>
                            <td class="text-center font-size-sm">{{ $product->sku }}</td>
                            <td class="text-center">
                                <i class="fa fa-fw fa-{{ $product->status ? 'star text-success' : 'warning text-danger' }}"></i>
                            </td>
                            <td class="font-w600">
                                <a href="{{ route('product.edit', ['id' => $product->id]) }}">{{ $product->name }}</a>
                                @if ($product->actions)
                                    <span class="badge badge-pill badge-success">{{ $product->actions->name }}</span>
                                @endif
                            </td>
                            <td class="text-center pl-3">
                                @foreach ($product->categories as $cat)
                                    <span class="badge badge-pill badge-light">{{ \Illuminate\Support\Str::limit($cat->name, 12) }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @if ($product->quantity < 1)
                                    <span class="text-danger">{{ $product->quantity }}</span>
                                @elseif($product->quantity < 4)
                                    <span class="text-warning">{{ $product->quantity }}</span>
                                @else
                                    <span class="text-success">{{ $product->quantity }}</span>
                                @endif
                            </td>
                            <td class="text-right font-size-sm">
                                <strong>{{ number_format($product->price, 2, ',', '.') }}</strong> <span class="text-muted">kn</span>
                            </td>
                            <td class="text-right font-size-sm">
                                <button type="button" class="btn btn-sm btn-circle btn-alt-danger" onclick="event.preventDefault(); shouldDelete({{ $product }});">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
                </div>
                {{ $products->links('back.layouts.partials.paginate') }}

            </div>
        </div>

    </div>

@endsection

@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="{{ asset('js/components/ag-autocomplete.js') }}"></script>
    <script>
        $(() => {
            $('#category-select').select2({
                placeholder: "Odaberi Kategorije...",
                allowClear: true
            });
            $('#manufacturer-select').select2({
                placeholder: "Odaberi Proizvođača...",
                allowClear: true
            });

            $('#category-select').on('change', (e) => {
                setURL('category', e.currentTarget.selectedOptions[0]);
            });
            $('#manufacturer-select').on('change', (e) => {
                setURL('manufacturer', e.currentTarget.selectedOptions[0]);
            });
        });

        function setURL(type, search) {
            let url = new URL(location.href);
            let params = new URLSearchParams(url.search);
            let keys = [];

            for(var key of params.keys()) {
                if (key === type) {
                    keys.push(key);
                }
            }

            keys.forEach((value) => {
                if (params.has(value)) {
                    params.delete(value);
                }
            })

            if (search.value) {
                params.append(type, search.value);
            }

            url.search = params;
            location.href = url;
        }

        function SelectStatus(status) {
            let url = new URL(location.href)
            let params = new URLSearchParams(url.search)
            let keys = []

            for(var key of params.keys()) {
                if (key === 'status') {
                    keys.push(key)
                }
            }

            keys.forEach((value) => {
                if (params.has(value)) {
                    params.delete(value)
                }
            })

            if (status && status !== 'all') {
                params.append('status', status)
            }

            url.search = params
            location.href = url
        }

        function shouldDelete(item) {
            console.log(item)

            confirmPopUp.fire({
                title: 'Jeste li sigurni?',
                text: 'Potvrdite brisanje proizvoda: ' + item.name,
                type: 'warning',
                confirmButtonText: 'Da, Obriši!',
            }).then((result) => {
                if (result.value) {
                    deleteItem(item.id)
                }
            })
        }

        function deleteItem(id) {
            axios.post("{{ route('product.destroy') }}", {id: id})
                .then(r => {
                    console.log(r)
                    if (r.data) {
                        successToast.fire({
                            text: 'Proizvod uspješno obrisan!',
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
