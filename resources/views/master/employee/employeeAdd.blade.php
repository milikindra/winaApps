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
                    <form id="form" action="{{ route('employeeAddSave') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <div class="row">
                                <h3 class="card-title">Formulir Karyawan Baru</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Username*</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email*</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan Email" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password*</label>
                                        <input type="password" class="form-control" name="password" id="password1" placeholder="Masukkan Password" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Ulangi Password*</label>
                                        <input type="password" class="form-control" name="re-password" id="re-password" placeholder="Ulangi Password" required>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nomor Induk Karyawan*</label>
                                        <input type="text" class="form-control numaja" name="employee_id" id="employee_id" placeholder="Masukkan Nomor Induk Karyawan" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nama Lengkap*</label>
                                        <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Masukkan Nama Lengkap" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" class="form-control" name="pob" id="pob" placeholder="Masukkan Tempat Lahir">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="dob" id="dob" placeholder="Masukkan tanggal Lahir">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Kewarganegaraan</label>
                                        <input type="text" class="form-control" name="nationality" id="nationality" placeholder="Masukkan Kewarganegaraan">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nomor Induk Kependudukan</label>
                                        <input type="text" class="form-control numaja" name="national_id" id="national_id" placeholder="Masukkan Nomor Induk Kependudukan">
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Provinsi</label>
                                        <select class="form-control select2" name="province" id="province" onchange="getCity()" required>
                                            <option selected disabled></option>
                                            @foreach($province as $i)
                                            <option value="{{$i->province_id}}">{{$i->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Kabupaten/Kota</label>
                                        <input type="text" class="form-control" name="city" id="city" placeholder="Masukkan Nomor Induk Kependudukan">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <input type="text" class="form-control" name="district" id="district" placeholder="Masukkan Kewarganegaraan">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Desa/Kelurahan</label>
                                        <input type="text" class="form-control" name="village" id="village" placeholder="Masukkan Nomor Induk Kependudukan">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Masukkan Alamat">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Kode Pos</label>
                                        <input type="text" class="form-control numaja" name="postal_code" id="postal_code" placeholder="Masukkan Kode Pos">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Telp</label>
                                        <input type="tel" class="form-control numaja" name="phone" id="phone" placeholder="Masukkan Nomor Telpon">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Status Pernikahan</label>
                                        <input type="text" class="form-control" name="marital_status" id="marital_status" placeholder="Masukkan tanggal Lahir">
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Jenis PTKP</label>
                                        <input type="text" class="form-control" name="ptkp_type" id="ptkp_type" placeholder="Masukkan Tempat Lahir">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>NPWP</label>
                                        <input type="text" class="form-control numaja" name="tax_id" id="tax_id" placeholder="Masukkan Nomor Pokok Wajib Pajak">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tanggal Mulai Tugas</label>
                                        <input type="date" class="form-control" name="join_date" id="join_date" placeholder="Tanggal Mulai Tugas">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Foto (JPEG/PNG)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="user_image" id="user_image">
                                                <label class="custom-file-label" for="user_image">Cari File ..</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-warning "><b>Kembali</b></a>
                            <button type="submit" class="btn btn-info float-right">SIMPAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('other-script')
<script>
    var rute_city = "{{ URL::to('financial/getCity') }}";
    var url_default = "{{ URL('') }}";
</script>

<script src="{{ asset('js/master/employee/employee-add.js')}}"></script>
@endpush