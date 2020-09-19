@if ($errors->any())
    <div class="alert alert-danger">
        <i class="fa fa-exclamation-circle"></i> Molimo vas da provjerite formu za unos podataka..! Možda nedostaju koji podaci?
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        <i class="fa fa-exclamation-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
@endif
