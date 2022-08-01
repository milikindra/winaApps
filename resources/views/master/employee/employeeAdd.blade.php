@extends('template.main-template')

@section('main-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="m-0">{{ $title }}</h5>
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
                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Username*</label>
                                        <input type="text" class="form-control form-control-sm" name="username" id="username" placeholder="Masukkan Username" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Email*</label>
                                        <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Masukkan Email" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Password*</label>
                                        <input type="password" class="form-control form-control-sm" name="password" id="password1" placeholder="Masukkan Password" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Ulangi Password*</label>
                                        <input type="password" class="form-control form-control-sm" name="re-password" id="re-password" placeholder="Ulangi Password" required>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Nomor Induk Karyawan*</label>
                                        <input type="text" class="form-control form-control-sm" name="employee_id" id="employee_id" placeholder="Masukkan Nomor Induk Karyawan" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Nama Lengkap*</label>
                                        <input type="text" class="form-control form-control-sm" name="full_name" id="full_name" placeholder="Masukkan Nama Lengkap" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Tempat Lahir</label>
                                        <input type="text" class="form-control form-control-sm" name="pob" id="pob" placeholder="Masukkan Tempat Lahir">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control form-control-sm" name="dob" id="dob" placeholder="Masukkan tanggal Lahir">
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Kewarganegaraan</label>
                                        <input type="text" class="form-control form-control-sm" name="nationality" id="nationality" placeholder="Masukkan Kewarganegaraan">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Nomor Induk Kependudukan</label>
                                        <input type="text" class="form-control form-control-sm numaja" name="national_id" id="national_id" placeholder="Masukkan Nomor Induk Kependudukan">
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Provinsi</label>
                                        <select class="form-control form-control-sm select2" name="province" id="province" onchange="getCity()" required>
                                            <option selected disabled></option>
                                            @foreach($province as $i)
                                            <option value="{{$i->province_id}}">{{$i->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Kabupaten/Kota</label>
                                        <input type="text" class="form-control form-control-sm" name="city" id="city" placeholder="Masukkan Nomor Induk Kependudukan">
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Kecamatan</label>
                                        <input type="text" class="form-control form-control-sm" name="district" id="district" placeholder="Masukkan Kewarganegaraan">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Desa/Kelurahan</label>
                                        <input type="text" class="form-control form-control-sm" name="village" id="village" placeholder="Masukkan Nomor Induk Kependudukan">
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control form-control-sm" name="address" id="address" placeholder="Masukkan Alamat">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Kode Pos</label>
                                        <input type="text" class="form-control form-control-sm numaja" name="postal_code" id="postal_code" placeholder="Masukkan Kode Pos">
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Telp</label>
                                        <input type="tel" class="form-control form-control-sm numaja" name="phone" id="phone" placeholder="Masukkan Nomor Telpon">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Status Pernikahan</label>
                                        <input type="text" class="form-control form-control-sm" name="marital_status" id="marital_status" placeholder="Masukkan tanggal Lahir">
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Jenis PTKP</label>
                                        <input type="text" class="form-control form-control-sm" name="ptkp_type" id="ptkp_type" placeholder="Masukkan Tempat Lahir">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>NPWP</label>
                                        <input type="text" class="form-control form-control-sm" name="tax_id" id="tax_id" placeholder="Masukkan Nomor Pokok Wajib Pajak">
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Tanggal Mulai Tugas</label>
                                        <input type="date" class="form-control form-control-sm" name="join_date" id="join_date" placeholder="Tanggal Mulai Tugas">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group margbot-5">
                                        <label>Foto (JPEG/PNG)</label>
                                        <br />
                                        <input type="file" name="user_image" id="user_image">
                                        <!-- <input type="file" name="user_image"  id="user_image"> -->
                                        <!-- <label for="user_image">Select a file:</label> -->
                                        <!-- <div class="input-group">
                                            <div class="custom-file custom-file-sm">
                                                <input type="file" class="form-control form-control-sm" name="user_image" id="user_image">
                                                <label class="custom-file-label custom-file-label-sm" for="user_image">Search File ..</label>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-sm btn-warning "><b>Back</b></a>
                            <button type="submit" class="btn btn-sm btn-info float-right">Save</button>
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