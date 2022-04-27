@extends('template.main-template')

@section('main-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset($user->user_image)}}" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{ $user->full_name}}</h3>
                        <p class="text-muted text-center">{{ $user->employee_id}}</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Username</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->username}}</label>
                            <label class="col-sm-2 col-form-label">Email</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->email}}</label>
                        </div>
                        <hr />
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor Induk Karyawan</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->employee_id}}</label>
                            <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->full_name}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tempat Lahir</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->pob}}</label>
                            <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ date_format(date_create($user->dob), 'd-m-Y')}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kewarganegaraan</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->nationality}}</label>
                            <label class="col-sm-2 col-form-label">Nomor Induk Kependudukan</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->national_id}}</label>
                        </div>
                        <hr />
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Provinsi</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->province_name}}</label>
                            <label class="col-sm-2 col-form-label">Kota/Kabupaten</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->city_name}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kecamatan</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->district_name}}</label>
                            <label class="col-sm-2 col-form-label">Desa/Kelurahan</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->village_name}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->address}}</label>
                            <label class="col-sm-2 col-form-label">Kode Pos</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->postal_code}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Telp.</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->phone}}</label>
                            <label class="col-sm-2 col-form-label">Status Pernikahan</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->marital}}</label>
                        </div>
                        <hr />
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis PTKP</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->ptkp}}</label>
                            <label class="col-sm-2 col-form-label">NPWP</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ $user->tax_id}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal Mulai Tugas</label>
                            <label class="col-sm-4 col-form-label" style="font-weight:normal;">: {{ date_format(date_create($user->join_date), 'd-m-Y')}} </label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-warning "><b>Kembali</b></a>
                        <a href="{{url('employeeEdit/'.$user->user_id)}}" class="btn btn-info float-right"><b>Edit</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('other-script')
<script>
    function changeImage() {
        $('#imgupload').trigger('click');
    }
</script>
@endpush