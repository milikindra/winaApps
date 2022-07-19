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
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset($user->user_image)}}" alt="User profile picture" style="padding:0; border:none">
                        </div>
                        <h5 class="text-center">{{ $user->full_name}}</h5>
                        <p class="text-muted text-center">{{ $user->employee_id}}</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 ">Username</label>
                            <label class="col-sm-4 " style="font-weight:normal;">: {{ $user->username}}</label>
                            <label class="col-sm-2 ">Email</label>
                            <label class="col-sm-4 " style="font-weight:normal;">: {{ $user->email}}</label>
                        </div>
                        <hr />
                        <div class="form-group row">
                            <label class="col-sm-2">Employee Id</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->employee_id}}</label>
                            <label class="col-sm-2">Full Name</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->full_name}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Place of Birth</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->pob}}</label>
                            <label class="col-sm-2">Date of Birth</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ date_format(date_create($user->dob), 'd-m-Y')}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Nationality</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->nationality}}</label>
                            <label class="col-sm-2">National Id</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->national_id}}</label>
                        </div>
                        <hr />
                        <div class="form-group row">
                            <label class="col-sm-2">Province</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->province_name}}</label>
                            <label class="col-sm-2">City</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->city_name}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">District</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->district_name}}</label>
                            <label class="col-sm-2">Village</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->village_name}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Address</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->address}}</label>
                            <label class="col-sm-2">Postal Code</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->postal_code}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Phone.</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->phone}}</label>
                            <label class="col-sm-2">Marital Status</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->marital}}</label>
                        </div>
                        <hr />
                        <div class="form-group row">
                            <label class="col-sm-2">PTKP</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->ptkp}}</label>
                            <label class="col-sm-2">NPWP</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ $user->tax_id}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Join Date</label>
                            <label class="col-sm-4" style="font-weight:normal;">: {{ date_format(date_create($user->join_date), 'd-m-Y')}} </label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-warning btn-sm"><b>Back</b></a>
                        <a href="{{url('employeeEdit/'.$user->user_id)}}" class="btn btn-info float-right btn-sm"><b>Edit</b></a>
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