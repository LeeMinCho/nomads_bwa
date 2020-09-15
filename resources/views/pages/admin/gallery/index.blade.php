@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gallery</h1>
        <button class="btn btn-sm btn-primary shadow-sm" id="add-gallery" type="button">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create Gallery
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="table-gallery">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Travel</th>
                            <th>Gambar</th>
                            <th>Date created</th>
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
<div class="modal fade" id="modalTravelPackage" tabindex="-1" aria-hidden="true">
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
                <label for="travel_packages_id">Travel Package</label>
                <select name="travel_packages_id" class="form-control select2" id="travel_packages_id" placeholder="Pilih">
                    <option value="">Pilih</option>
                </select>
                <div class="error"></div>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" placeholder="Image" class="form-control">
                <div class="error"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="create-travel-package">Save</button>
          <button type="button" class="btn btn-primary" id="update-travel-package">Save</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function () {
            galleryDatatable();

            $("#travel_packages_id").each(function () {
                $(this).select2({
                    theme: 'bootstrap4',
                    width: 'style',
                    placeholder: $(this).attr('placeholder'),
                    allowClear: true,
                    ajax: {
                        url: "{{ route("travel-package-select") }}",
                        dataType: "json",
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            let results = [];
                            $.each(data.travel_package, function(index, item) {
                                results.push({
                                    id: item.id,
                                    text: item.location
                                });
                            });
                            return {
                                results: results
                            };
                        }
                    }
                });
            });

            $("#add-gallery").on("click", function () {
                $(".error").html("");
                $("#email").val("");
                $("#name").val("");
                $("#password").val("");
                $("#password_confirmation").val("");
                $("#travel_packages_id").val(null).trigger("change");
                $("#modalTravelPackage").find(".modal-title").html("Add Travel Package");
                $("#modalTravelPackage").find("#create-travel-package").show();
                $("#modalTravelPackage").find("#update-travel-package").hide();
                $("#modalTravelPackage").modal("show");
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

            $("#table-gallery").on('click', '#delete-gallery', function(event) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Image will be deleted",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                })
                .then((willDelete) => {
                    if (willDelete.value) {
                        var id = $(this).data("id");
                        $.ajax({
                            url: "{{ url("admin/gallery") }}/" + id,
                            type: "DELETE",
                            success: function (data) {
                                var obj = JSON.parse(data);
                                console.log(obj);
                                Swal.fire({
                                    title: "Deleted",
                                    text: obj.message,
                                    icon: "success",
                                    showCancelButton: true,
                                    showConfirmButton: true,
                                    timer: 2500,
                                });
                                setTimeout(function () {
                                    galleryDatatable();
                                }, 2500);
                            }
                        });
                    }
                });
            });
        });

        function galleryDatatable() {
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

            var table = $("#table-gallery").DataTable({
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
                ajax: '{!! route('gallery-datatable') !!}',
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'travel_package.location', name: 'travel_package.location' },
                    { data: 'image', name: 'image' },
                    { data: 'created_at', name: 'created_at' },
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