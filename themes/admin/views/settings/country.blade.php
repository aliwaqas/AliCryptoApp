@extends('layouts.master')

@section('content')


    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Country List</h3>

                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add Country</a>
                    </div>
                </div>
            </div>
			<!-- /Page Header -->

            <!-- Search Filter -->
            <form action="" method="POST">
                {{-- {{ route('search/user/list') }} --}}
                @csrf
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="name" name="name">
                            <label class="focus-label">Slug</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="role_name" name="role_name">
                            <label class="focus-label">Country Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="status" name="status">
                            <label class="focus-label">Status</label>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                        <button type="sumit" class="btn btn-success btn-block"> Search </button>
                    </div>
                </div>
            </form>
            <!-- /Search Filter -->
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="load_data" class="table table-striped custom-table  ">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Flag</th>
                                    <th>Code</th>
                                    <th>Country Name</th>
                                    <th>Time Zone</th>
                                    <th >Status</th>

                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->


        <!-- Add User Modal -->
        <div id="add_user" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Country</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.user/add/save') }}" method="POST" enctype="multipart/form-data" id="addform" >
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Short Code</label>
                                        <input class="slug form-control" type="text"  name="slug" value="{{ old('slug') }}" placeholder="Enter Country Short Code">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Country Name</label>
                                    <input class="name form-control" type="text"  name="name" placeholder="Enter Country Full Name">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Country Flag</label>
                                        <input class="img form-control" type="file"  name="img" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Country Details</label>
                                    <input class="details form-control" type="text" name="details" placeholder="Enter Details">
                                </div>
                            </div>

                            <div class="submit-section">
                                <button id="submit" type="submit" class="btn btn-primary submit-btn submitdata">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add User Modal -->

        <!-- Edit User Modal -->
        <div id="edit_user" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Country</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <form action="{{ route('admin.update.country.details') }}" method="POST" enctype="multipart/form-data" id="update-country-form">
                            @csrf
                            <input type="hidden" name="rec_id" id="e_id" value="">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Short Code</label>
                                    <input id="e_slug" class="slug form-control" type="text"  name="slug" value="" placeholder="Enter Country Short Code">
                                </div>
                                <div class="col-sm-6">
                                    <label>Country Name</label>
                                    <input class="name form-control" type="text"  name="name" placeholder="Enter Country Full Name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Status</label>
                                    <select class="select" name="status" id="e_status">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>

                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label>Country Details</label>
                                    <input class="details form-control" type="text" name="name" placeholder="Enter Details">
                                </div>
                            </div>
                            <br>

                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Photo</label>
                                    <input class="form-control" type="file" id="img" name="img">
                                </div>
                            </div>
                            <br>
                            <div class="submit-section">
                                <button id="editbtn" type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Salary Modal -->


    </div>
    <!-- /Page Wrapper -->
    @section('script')
    {{-- update js --}}
    <script>


        $(document).ready(function () {

            //  Add Data

            $("form#addform").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                //var data = $(this).serialize();
                $.ajax({
                    type: "post",
                    url: "/admin/settings/country",
                    data: formData,
                    contentType: false,
                    processData: false,
                    //dataType: "json",
                    success: function (response) {
                        console.log(response)
                        if(response.status == 400)
                        {
                            toasterOptions();
                            $('#add_model').find('input').val("");


                            errorMessage = response.message;
                            $.each(errorMessage, function(index, value)
                            {
                                if (value.length != 0)
                                {
                                    toastr.error(value);
                                }
                            });

                        }
                        else if(response.status == 200)
                        {
                            toasterOptions();
                            toastr.success('Country Added Successfully.');
                            $('#add_model').find('input').val("");
                            $('#load_data').DataTable().ajax.reload(null, false);
                            swal.fire("Done!", response.msg, "success");
                        }
                    },
                    error: function(xhr, status, error){
                        var errorMessage = xhr.status + ': ' + xhr.statusText
                        toasterOptions();
                        toastr.error(errorMessage);
                    }
                });

            });


            //GET ALL COUNTRIES
            var table =  $('#load_data').DataTable({
                    processing:true,
                    // serverSide:true,
                    destroy:true,
                    ajax:{
                        url: "{{ route('admin.get.countris.list') }}",
                        type: 'get',
                        data:{
                            status: 'Active',
                        }

                    },
                    "pageLength":10,
                    "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
                    columns:[
                        {data:'id', name:'id'},
                        {data:'flagImg', name:'flagImg'},
                        {data:'slug', name:'slug'},
                        {data:'name', name:'name'},
                        {data:'time_zone', name:'time_zone'},
                        {data:'statusBtn', name:'statusBtn', orderable:false, searchable:false},
                        {data:'actions', name:'actions', orderable:false, searchable:false},
                    ]
            });

            //Load ALL Data in the Form

            $(document).on('click','.userUpdate',function()
            {
                var dataID = $(this).data('id');
                var _this = $(this).parents('tr');
                $('#e_id').val(_this.find(dataID).text());
                $('#e_slug').val(_this.find(dataID).text());



            });


            //DELETE COUNTRY RECORD
            $(document).on('click','.userDelete',function()
            {
                debugger;
                var dataID = $(this).data('id');
                var url = '<?= route("admin.delete.country") ?>';

                swal.fire({
                    title: "Delete?",
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: !0
                }).then(function(result){
                        if(result.value){
                            var CSRF_TOKEN = "{{ csrf_token() }}";
                            $.post(url,{dataID:dataID, _token: CSRF_TOKEN}, function(data){
                                if(data.code == 1){
                                    $('#load_data').DataTable().ajax.reload(null, false);
                                    swal.fire("Done!", data.msg, "success");
                                    // refresh page after 2 seconds
                                    // setTimeout(function(){
                                    //     location.reload();
                                    // },9000);
                                }else{
                                    swal.fire("Error!", data.message, "error");
                                }
                            },'json');
                        }
                });

            });


            //Update Statuss
            $(document).on('click','.activeStatus',function()
            {
                var rowStatus = $(this).attr("data-status");
                var rowID = $(this).data('id');
                var statusUrl = '<?= route("admin.update.country.status") ?>';
                swal.fire({
                    title: "Change Status To "+rowStatus,
                    icon: 'question',
                    text: "Please ensure and then confirm!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, please update ",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: !0
                }).then(function(result){
                    debugger;
                        if(result.value){
                            var CSRF_TOKEN = "{{ csrf_token() }}";
                            $.post(
                                statusUrl,{
                                    rowID:rowID,
                                    _token: CSRF_TOKEN,
                                    status: rowStatus
                                }, function(data){
                                if(data.code == 200){
                                    $('#load_data').DataTable().ajax.reload(null, false);
                                    swal.fire("Done!", data.msg, "success");
                                    // refresh page after 2 seconds
                                    // setTimeout(function(){
                                    //     location.reload();
                                    // },9000);
                                }else{
                                    console.log(data.msg);
                                    swal.fire("Error!", data.msg, "error");
                                }
                            },'json');
                        }
                });



            });



            //UPDATE COUNTRY DETAILS
            $('#update-country-form').on('submit', function(e){
                debugger;
                e.preventDefault();
                var form = this;
                console.log(form);

                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend: function(){
                            $(form).find('span.error-text').text('');
                    },
                    success: function(data){
                        swal.fire("Done!", data.msg, "success");
                            if(data.code == 0){
                                $.each(data.error, function(prefix, val){
                                    $(form).find('span.'+prefix+'_error').text(val[0]);
                                });
                            }else{
                                $('#counties-table').DataTable().ajax.reload(null, false);
                                $('.editCountry').modal('hide');
                                $('.editCountry').find('form')[0].reset();
                                toastr.success(data.msg);
                            }
                    }
                });
            });







        });



        // Notification Options

        function toasterOptions() {
            toastr.options = {
                "closeButton": true,
                // "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                // "positionClass": "toast-top-right",
                // "preventDuplicates": true,
                // "onclick": null,
                // "showDuration": "100",
                // "hideDuration": "2000",
                "timeOut": "5000",
                // "extendedTimeOut": "2000",
                // "showEasing": "swing",
                // "hideEasing": "linear",
                // "showMethod": "show",
                // "hideMethod": "hide"
            };
        };
    </script>


    @endsection

@endsection
