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
                            <img onclick="changeImage()" style="cursor: pointer;" class="profile-user-img img-fluid img-circle" src="{{ asset(session('user')->user_image)}}" alt="User profile picture">
                        </div>
                        <input type="file" id="imgupload" style="display:none" />
                        <h3 class="profile-username text-center">{{ session('user')->full_name}}</h3>
                        <p class="text-muted text-center">{{ session('user')->employee_id}}</p>
                        <a href="#" class="btn btn-info btn-block"><b>Edit</b></a>
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