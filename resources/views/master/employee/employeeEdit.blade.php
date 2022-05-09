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
                            <img onclick="changeImage()" style="cursor: pointer;" class="profile-user-img img-fluid img-circle" src="{{asset($user->user_image)}}" alt="User profile picture">
                        </div>
                        <!-- <input type="file" id="imgupload" style="display:none" /> -->
                        <h3 class="profile-username text-center">{{$user->full_name}}</h3>
                        <p class="text-muted text-center">{{$user->employee_id}}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username*</label>
                                    <input type="text" class="form-control" name="username" id="username" value="{{$user->username}}" placeholder="Masukkan Username" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email*</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{$user->email}}" placeholder="Masukkan Email" required>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nomor Induk Karyawan*</label>
                                    <input type="text" class="form-control" name="employee_id" id="employee_id" value="{{$user->employee_id}}" placeholder="Masukkan Nomor Induk Karyawan" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama Lengkap*</label>
                                    <input type="text" class="form-control" name="full_name" id="full_name" value="{{$user->full_name}}" placeholder="Masukkan Nama Lengkap" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control" name="pob" id="pob" value="{{$user->pob}}" placeholder="Masukkan Tempat Lahir">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="dob" id="dob" value="{{$user->dob}}" placeholder="Masukkan tanggal Lahir">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Kewarganegaraan</label>
                                    <input type="text" class="form-control" name="nationality" id="nationality" value="{{$user->nationality}}" placeholder="Masukkan Kewarganegaraan">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nomor Induk Kependudukan</label>
                                    <input type="text" class="form-control numaja" name="national_id" id="national_id" value="{{$user->national_id}}" placeholder="Masukkan Nomor Induk Kependudukan">
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <input type="text" class="form-control" name="province" id="province" placeholder="Masukkan Kewarganegaraan">
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
                                    <input type="date" class="form-control" name="marital_status" id="marital_status" placeholder="Masukkan tanggal Lahir">
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
                        <button type="submit" class="btn btn-info float-right">Simpan</button>
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
        $('#user_image').trigger('click');
    }
</script>
@endpush