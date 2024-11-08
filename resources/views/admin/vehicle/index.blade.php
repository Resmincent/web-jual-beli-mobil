@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 text-gray-800">{{ __('List Kendaraan') }}</h1>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert">
    <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <form method="GET" action="{{ route('vehicles.index') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-control" placeholder="{{ __('Search users...') }}" value="{{ request()->input('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm">{{ __('Search') }}</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-2">
                <label for="startDate">Start Date</label>
                <div class="form-group">
                    <input type="date" name="start_date" class="form-control" id="startDate" value="{{ request()->input('start_date') }}">
                </div>
            </div>
            <div class="col-lg-2">
                <label for="endDate">End Date</label>
                <div class="form-group">
                    <input type="date" name="end_date" class="form-control" id="endDate" placeholder="End Date" value="{{ request()->input('end_date') }}">
                </div>
            </div>
            <div class="col-lg-2">
                <a href="{{ route('vehicles.create') }}" class="btn btn-md btn-primary">
                    Tambah Kendaraan
                </a>
            </div>
        </div>

        <div class="table-responsive table-responsive-sm">
            <table class="table align-middle border rounded table-row-dashed fs-6 g-5">
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                        <th class="min-w-100px">Nama</th>
                        <th class="min-w-100px">Brand</th>
                        <th class="min-w-100px">Kategori</th>
                        <th class="min-w-100px">Price</th>
                        <th class="min-w-100px">Tanggal Dibuat</th>
                        <th class="min-w-100px">Aksi</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>$320,800</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Garrett Winters</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>63</td>
                        <td>$170,750</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Ashton Cox</td>
                        <td>Junior Technical Author</td>
                        <td>San Francisco</td>
                        <td>2009-01-12</td>
                        <td>$86,000</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Cedric Kelly</td>
                        <td>Senior Javascript Developer</td>
                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>$433,060</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Airi Satou</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>33</td>
                        <td>$162,700</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Brielle Williamson</td>
                        <td>Integration Specialist</td>
                        <td>New York</td>
                        <td>61</td>
                        <td>$372,000</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination justify-content-center mb-10">
        {{-- {{ $users->appends(['search' => request()->input('search')])->links() }} --}}
    </div>

</div>
@endsection
