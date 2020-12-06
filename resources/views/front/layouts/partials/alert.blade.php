@if ($errors->any())
    <div class="col-lg-12">
        <div class="style-msg errormsg">
            <div class="sb-msg"><i class="icon-remove"></i><strong>Whoops..!</strong> Molimo vas da provjerite formu za unos podataka..! Možda nedostaju koji podaci?</div>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        <i class="fa fa-exclamation-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
@endif
