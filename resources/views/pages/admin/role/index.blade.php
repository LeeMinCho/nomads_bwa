@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Role</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <button type="button" id="add-role" class="btn btn-sm btn-primary shadow-sm mb-4">
                <i class="fas fa-plus fa-sm text-white-50"></i> Create Role
            </button>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="table-role">
                    <thead>
                        <tr>
                            <th>No</th>
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
<div class="modal fade" id="modalRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
                <label for="role">Role</label>
                <input type="text" name="role" id="role" class="form-control" placeholder="Role">
                <div class="error"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="create-role">Save</button>
          <button type="button" class="btn btn-primary" id="update-role">Save</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function () {
            roleDatatable();

            $("#add-role").on("click", function () {
                $("#id").val("");
                $("#role").val("");
                $(".error").html("");
                $("#modalRole").find(".modal-title").html("Add Role");
                $("#modalRole").find("#create-role").show();
                $("#modalRole").find("#update-role").hide();
                $("#modalRole").modal("show");
            });

            $("#create-role").click(function () {
                $.ajax({
                    url: "{{ route("role.store") }}",
                    type: "POST",
                    data: {
                        "role": $("#role").val()
                    },
                    dataType: "json",
                    error: function (xhr, textStatus, error) {
                        var response = xhr.responseJSON;
                        if (xhr.status == 422) {
                            $("#role").parents(".form-group").find(".error").html("<span class='text text-danger'>" + (response.errors.role ? response.errors.role : "") + "</span>");
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

        function roleDatatable() {
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

            var table = $("#table-role").DataTable({
                initComplete: function() {
                    var api = this.api();
                    $('#table-role_filter input')
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
                ajax: '{!! route('role-datatable') !!}',
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'role', name: 'role' },
                    { data: 'action', name: 'action', orderable: false },
                ],
                order: [[1, 'desc']],
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