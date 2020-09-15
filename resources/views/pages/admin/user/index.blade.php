@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <button type="button" id="add-user" class="btn btn-sm btn-primary shadow-sm mb-4">
                <i class="fas fa-plus fa-sm text-white-50"></i> Create User Admin
            </button>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="table-user">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Registered At</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                <div class="error"></div>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                <div class="error"></div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                <div class="error"></div>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password Confirmation">
                <div class="error"></div>
            </div>
            <div class="form-group">
                <label for="roles_id">Role</label>
                <select name="roles_id" class="form-control select2" id="roles_id" placeholder="Pilih">
                    <option value="">Pilih</option>
                </select>
                <div class="error"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="create-user">Save</button>
          <button type="button" class="btn btn-primary" id="update-user">Save</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function () {
            userDatatable();

            $("#roles_id").each(function () {
                $(this).select2({
                    theme: 'bootstrap4',
                    width: 'style',
                    placeholder: $(this).attr('placeholder'),
                    allowClear: true,
                    ajax: {
                        url: "{{ route("role-select") }}",
                        dataType: "json",
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            let results = [];
                            $.each(data.role, function(index, item) {
                                results.push({
                                    id: item.id,
                                    text: item.role
                                });
                            });
                            return {
                                results: results
                            };
                        }
                    }
                });
            });

            $("#add-user").on("click", function () {
                $(".error").html("");
                $("#email").val("");
                $("#name").val("");
                $("#password").val("");
                $("#password_confirmation").val("");
                $("#roles_id").val(null).trigger("change");
                $("#modalUser").find(".modal-title").html("Add User");
                $("#modalUser").find("#create-user").show();
                $("#modalUser").find("#update-user").hide();
                $("#modalUser").modal("show");
            });

            $("#create-user").click(function () {
                $.ajax({
                    url: "{{ route("user.store") }}",
                    type: "POST",
                    data: {
                        "email": $("#email").val(),
                        "name": $("#name").val(),
                        "password": $("#password").val(),
                        "password_confirmation": $("#password_confirmation").val(),
                        "roles_id": $("#roles_id").val(),
                    },
                    dataType: "json",
                    error: function (xhr, textStatus, error) {
                        var response = xhr.responseJSON;
                        if (xhr.status == 422) {
                            $("#email").parents(".form-group").find(".error").html("<span class='text text-danger'>" + (response.errors.email ? response.errors.email : "") + "</span>");
                            $("#name").parents(".form-group").find(".error").html("<span class='text text-danger'>" + (response.errors.name ? response.errors.name : "") + "</span>");
                            $("#password").parents(".form-group").find(".error").html("<span class='text text-danger'>" + (response.errors.password ? response.errors.password : "") + "</span>");
                            $("#password_confirmation").parents(".form-group").find(".error").html("<span class='text text-danger'>" + (response.errors.password_confirmation ? response.errors.password_confirmation : "") + "</span>");
                            $("#roles_id").parents(".form-group").find(".error").html("<span class='text text-danger'>" + (response.errors.roles_id ? response.errors.roles_id : "") + "</span>");
                        }
                    }
                }).done(function (data) {
                    $("#modalUser").modal("hide");
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                        timer: 2500,
                        showConfirmButton: false,
                    });
                    setTimeout(function () {
                        userDatatable();
                    }, 2500);
                });
            });

            $("#table-role").on("click", "#edit-role", function () {
                var id = $(this).data("id");
                $("#id").val(id);
                $.ajax({
                    url: "{{ url("admin/role") }}/" + id,
                    dataType: "json",
                    success: function (data) {
                        $("#role").val(data.role);
                    }
                });
                $(".error").html("");
                $("#modalRole").find(".modal-title").html("Edit Role");
                $("#modalRole").find("#create-role").hide();
                $("#modalRole").find("#update-role").show();
                $("#modalRole").modal("show");
            });

            $("#update-role").click(function () {
                var id = $("#id").val();
                $.ajax({
                    url: "{{ url("admin/role") }}/" + id,
                    type: "PUT",
                    data: {
                        "_method": "PUT",
                        "role": $("#role").val(),
                        "id": id
                    },
                    dataType: "json",
                    error: function (xhr, textStatus, error) {
                        var response = xhr.responseJSON;
                        if (xhr.status == 422) {
                            $("#role").parents(".form-group").find(".error").html("<span class='text text-danger'>" + response.errors.role + "</span>");
                        }
                    }
                }).done(function (data) {
                    $("#modalRole").modal("hide");
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                        timer: 2500,
                        showConfirmButton: false,
                    });
                    setTimeout(function () {
                        roleDatatable();
                    }, 2500);
                });
            });
        });

        function userDatatable() {
            $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };

            var table = $("#table-user").DataTable({
                initComplete: function() {
                    var api = this.api();
                    $('#table-user_filter input')
                            .off('.DT')
                            .on('keyup.DT', function(e) {
                                if (e.keyCode == 13) {
                                    api.search(this.value).draw();
                        }
                    });
                },
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: '{!! route('user-datatable') !!}',
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'email_verified_at', name: 'email_verified_at' },
                    { data: 'role.role', name: 'role.role' },
                    { data: 'action', name: 'action', orderable: false },
                ],
                order: [[3, 'desc']],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                }
            });
        }
    </script>
@endpush