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
                    <div class="card-header box-profile">
                        <div class="text-center">
                            <img onclick="changeImage()" class="profile-user-img img-fluid img-circle" src="{{asset($user->user_image)}}" alt="User profile picture" style="cursor:pointer;padding:0; border:none;">
                        </div>
                        <!-- <input type="file" id="imgupload" style="display:none" /> -->
                        <h3 class="profile-username text-center">{{$user->full_name}}</h3>
                        <p class="text-muted text-center">{{$user->employee_id}}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Username*</label>
                                    <input type="text" class="form-control form-control-sm" name="username" id="username" value="{{$user->username}}" placeholder="Insert Username" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Email*</label>
                                    <input type="email" class="form-control form-control-sm" name="email" id="email" value="{{$user->email}}" placeholder="Insert Email" required>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Employee Id*</label>
                                    <input type="text" class="form-control form-control-sm" name="employee_id" id="employee_id" value="{{$user->employee_id}}" placeholder="Insert Employee Id" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Full Name*</label>
                                    <input type="text" class="form-control form-control-sm" name="full_name" id="full_name" value="{{$user->full_name}}" placeholder="Insert Full Name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Place of Birth</label>
                                    <input type="text" class="form-control form-control-sm" name="pob" id="pob" value="{{$user->pob}}" placeholder="Insert Place of Birth">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control form-control-sm" name="dob" id="dob" value="{{$user->dob}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Nationality</label>
                                    <input type="text" class="form-control form-control-sm" name="nationality" id="nationality" value="{{$user->nationality}}" placeholder="Insert Nationality">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>National Id</label>
                                    <input type="text" class="form-control form-control-sm numaja" name="national_id" id="national_id" value="{{$user->national_id}}" placeholder="Insert National Id">
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Province</label>
                                    <input type="text" class="form-control form-control-sm" name="province" id="province" placeholder="Insert Province">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>City</label>
                                    <input type="text" class="form-control form-control-sm" name="city" id="city" placeholder="Insert City">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>District</label>
                                    <input type="text" class="form-control form-control-sm" name="district" id="district" placeholder="Insert District">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Village</label>
                                    <input type="text" class="form-control form-control-sm" name="village" id="village" placeholder="Insert Village">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Address</label>
                                    <input type="text" class="form-control form-control-sm" name="address" id="address" placeholder="Insert Address">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Postal Code</label>
                                    <input type="text" class="form-control form-control-sm numaja" name="postal_code" id="postal_code" placeholder="Insert Postal Code">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Phone</label>
                                    <input type="tel" class="form-control form-control-sm numaja" name="phone" id="phone" placeholder="Insert Phone Number">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Marital Status</label>
                                    <input type="date" class="form-control form-control-sm" name="marital_status" id="marital_status" placeholder="Chose marital Status">
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>PTKP</label>
                                    <input type="text" class="form-control form-control-sm" name="ptkp_type" id="ptkp_type" placeholder="Chose PTKP">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control form-control-sm numaja" name="tax_id" id="tax_id" placeholder="Insert Tax Id">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Join Date</label>
                                    <input type="date" class="form-control form-control-sm" name="join_date" id="join_date">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margbot-5">
                                    <label>Photo (JPEG/PNG)</label>
                                    <div class="input-group ">
                                        <div class="custom-file form-control-sm">
                                            <input type="file" class="custom-file-input" name="user_image" id="user_image">
                                            <label class="custom-file-label" style="height: auto;" for="user_image">Search File ..</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-warning btn-sm"><b>Back</b></a>
                        <button type="submit" class="btn btn-info float-right btn-sm">Save</button>
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