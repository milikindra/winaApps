@extends('template.main-template')
@push('other-style')
<link rel="stylesheet" href="{{ asset('css/hierarchy-view.css') }}">
</style>
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
</style>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endpush

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
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12"><a href="{{ route('employeeAdd')}}" class="btn btn-info btn-sm btn-block">
                                    Add Employee
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title">Employee Data</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div id="loader">
                                <div class="loader2"></div>
                                <span id="txtLoading">Populating user matrix...</span>
                            </div>
                            <div id="tree" class="col-md-7"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('other-script')
<!-- <script>
    var rute = "{{ URL::to('employee/data/populate') }}";
    var base_url = "{{ route('employee') }}";
    var url_default = "{{ URL('') }}";
</script> -->

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var dataUserMatrix = "{{route('employee/getEmployeeMatrixList')}}";
    var token = "{{ csrf_token() }}";
    var userid = '{{ $userId }}';
    var old = '{!! json_encode($menuUser) !!}';
    var tree = "";
    $(document).ready(function() {

        tree = $('#tree').tree({
            primaryKey: 'id',
            dataSource: {
                url: dataUserMatrix,
                method: "GET",
                complete: function() {
                    $('#txtLoading').html("");
                    var n = "";
                    // try {
                    old = JSON.parse(old);
                    $.each(old, function(_key, _val) {
                        console.log(_val);
                        // n = _val;
                        // tree.check(tree.getNodeById(_val));
                    });
                    $('#loader').addClass('none-usual');
                    // } catch (exc) {
                    //     Swal.fire({
                    //         title: "Error!",
                    //         text: "Down Payment already used",
                    //         icon: "error",
                    //         confirmButtonColor: "#17a2b8",
                    //     })
                    //     $('#loader').addClass('none-usual');
                    //     tree.uncheckAll();
                    // }
                }
            },
            uiLibrary: 'bootstrap4',
            checkboxes: true
        });

        $('#save-btn').click(function(e) {
            $(this).html("<div style='display: inline-block;' class='loader2'></div>");
            $(this).attr("disabled", true);
            e.preventDefault();
            $.ajax({
                url: submitRoute,
                method: "POST",
                data: {
                    _token: token,
                    groupName: $('#name').val(),
                    userID: userid,
                    functiont: tree.getCheckedNodes()
                },
                success: function(e) {
                    window.location.replace(redirect);
                    Swal.fire({
                        title: "Sukses!",
                        text: "Down Payment already used",
                        icon: "error",
                        confirmButtonColor: "#17a2b8",
                    })
                },
                error: function(e) {
                    Swal.fire({
                        title: "Error!",
                        text: "Down Payment already used",
                        icon: "error",
                        confirmButtonColor: "#17a2b8",
                    })
                    $('#save-btn').html("<i class=\"fa fa-save\" aria-hidden=\"true\"> </i>&nbsp;Save");
                    $('#save-btn').attr("disabled", false);
                }
            });
        });

    });
</script>

@endpush