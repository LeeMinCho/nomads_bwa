@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Paket Travel</h1>
        <button id="add-travel-package" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Paket Travel
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="table-travel-package">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Departure Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="modalTravelPackage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Travel Package</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-6">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                        <div class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" id="location" class="form-control" placeholder="Location">
                        <div class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="about">About</label>
                        <textarea name="about" rows="3" id="about" class="d-block w-100 form-control"></textarea>
                        <div class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="featured_event">Featured Event</label>
                        <input type="text" name="featured_event" id="featured_event" class="form-control" placeholder="Featured Event">
                        <div class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="language">Language</label>
                        <input type="text" name="language" id="language" class="form-control" placeholder="Language">
                        <div class="error"></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="foods">Foods</label>
                        <input type="text" name="foods" id="foods" class="form-control" placeholder="Foods">
                        <div class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="departure_date">Departure Date</label>
                        <input type="date" name="departure_date" id="departure_date" class="form-control" placeholder="Departure Date">
                        <div class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control" placeholder="Duration">
                        <div class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <input type="text" name="type" id="type" class="form-control" placeholder="Type">
                        <div class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" placeholder="Price">
                        <div class="error"></div>
                    </div>
                </div>
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

<div class="modal fade" id="modalShowTravelPackage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Travel Package</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-6">
                    <table class="table table-striped">
                        <tr>
                            <th>Title</th>
                            <td id="sTitle"></td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td id="sLocation"></td>
                        </tr>
                        <tr>
                            <th>About</th>
                            <td id="sAbout"></td>
                        </tr>
                        <tr>
                            <th>Featured Event</th>
                            <td id="sFeaturedEvent"></td>
                        </tr>
                        <tr>
                            <th>Language</th>
                            <td id="sLanguage"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-6">
                    <table class="table table-striped">
                        <tr>
                            <th>Foods</th>
                            <td id="sFoods"></td>
                        </tr>
                        <tr>
                            <th>Departure Date</th>
                            <td id="sDepartureDate"></td>
                        </tr>
                        <tr>
                            <th>Duration</th>
                            <td id="sDuration"></td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td id="sType"></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td id="sPrice"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('addon-script')
    <script>
        $(document).ready(function () {
            travelPackageDatatable();

            $("#add-travel-package").on("click", function () {
                $("input, textarea").val("");
                $(".error").html("");
                $("#modalTravelPackage").find(".modal-title").html("Add Travel Package");
                $("#modalTravelPackage").find("#create-travel-package").show();
                $("#modalTravelPackage").find("#update-travel-package").hide();
                $("#modalTravelPackage").modal("show");
            });

            $("#create-travel-package").click(function () {
                $.ajax({
                    url: "{{ route("travel-package.store") }}",
                    type: "POST",
                    data: {
                        "title": $("#title").val(),
                        "location": $("#location").val(),
                        "about": $("#about").val(),
                        "featured_event": $("#featured_event").val(),
                        "language": $("#language").val(),
                        "foods": $("#foods").val(),
                        "departure_date": $("#departure_date").val(),
                        "duration": $("#duration").val(),
                        "type": $("#type").val(),
                        "price": $("#price").val(),
                    },
                    dataType: "json",
                    error: function (xhr, textStatus, error) {
                        var response = xhr.responseJSON;
                        if (xhr.status == 422) {
                            $("#title").parents(".form-group").find(".error").html(response.errors.title ? "<span class='text text-danger'>" + response.errors.title + "</span>" : "");
                            $("#location").parents(".form-group").find(".error").html(response.errors.location ? "<span class='text text-danger'>" + response.errors.location + "</span>" : "");
                            $("#about").parents(".form-group").find(".error").html(response.errors.about ? "<span class='text text-danger'>" + response.errors.about + "</span>" : "");
                            $("#featured_event").parents(".form-group").find(".error").html(response.errors.featured_event ? "<span class='text text-danger'>" + response.errors.featured_event + "</span>" : "");
                            $("#language").parents(".form-group").find(".error").html(response.errors.language ? "<span class='text text-danger'>" + response.errors.language + "</span>" : "");
                            $("#foods").parents(".form-group").find(".error").html(response.errors.foods ? "<span class='text text-danger'>" + response.errors.foods + "</span>" : "");
                            $("#departure_date").parents(".form-group").find(".error").html(response.errors.departure_date ? "<span class='text text-danger'>" + response.errors.departure_date + "</span>" : "");
                            $("#duration").parents(".form-group").find(".error").html(response.errors.duration ? "<span class='text text-danger'>" + response.errors.duration + "</span>" : "");
                            $("#type").parents(".form-group").find(".error").html(response.errors.type ? "<span class='text text-danger'>" + response.errors.type + "</span>" : "");
                            $("#price").parents(".form-group").find(".error").html(response.errors.price ? "<span class='text text-danger'>" + response.errors.price + "</span>" : "");
                        }
                    }
                }).done(function (data) {
                    $("#modalTravelPackage").modal("hide");
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                        timer: 2500,
                        showConfirmButton: false,
                    });
                    setTimeout(function () {
                        travelPackageDatatable();
                    }, 2500);
                });
            });

            $("#table-travel-package").on("click", "#show-travel-package", function () {
                var id = $(this).data("id");
                $.ajax({
                    url: "{{ url("admin/travel-package") }}/" + id,
                    dataType: "json",
                    success: function (data) {
                        $("#sTitle").html(data.title);
                        $("#sLocation").html(data.location);
                        $("#sAbout").html(data.about);
                        $("#sFeaturedEvent").html(data.featured_event);
                        $("#sLanguage").html(data.language);
                        $("#sFoods").html(data.foods);
                        $("#sDepartureDate").html(data.departure_date);
                        $("#sDuration").html(data.duration);
                        $("#sType").html(data.type);
                        $("#sPrice").html(data.price + " $");
                        $("#modalShowTravelPackage").modal("show");
                    }
                });
            });

            $("#table-travel-package").on("click", "#edit-travel-package", function () {
                var id = $(this).data("id");
                $("#id").val(id);
                $.ajax({
                    url: "{{ url("admin/travel-package") }}/" + id,
                    dataType: "json",
                    success: function (data) {
                        $("#title").val(data.title);
                        $("#location").val(data.location);
                        $("#about").val(data.about);
                        $("#featured_event").val(data.featured_event);
                        $("#language").val(data.language);
                        $("#foods").val(data.foods);
                        $("#departure_date").val(data.departure_date);
                        $("#duration").val(data.duration);
                        $("#type").val(data.type);
                        $("#price").val(data.price);
                    }
                });
                $(".error").html("");
                $("#modalTravelPackage").find(".modal-title").html("Edit Role");
                $("#modalTravelPackage").find("#create-travel-package").hide();
                $("#modalTravelPackage").find("#update-travel-package").show();
                $("#modalTravelPackage").modal("show");
            });

            $("#update-travel-package").click(function () {
                var id = $("#id").val();
                $.ajax({
                    url: "{{ url("admin/travel-package") }}/" + id,
                    type: "PUT",
                    data: {
                        "title": $("#title").val(),
                        "location": $("#location").val(),
                        "about": $("#about").val(),
                        "featured_event": $("#featured_event").val(),
                        "language": $("#language").val(),
                        "foods": $("#foods").val(),
                        "departure_date": $("#departure_date").val(),
                        "duration": $("#duration").val(),
                        "type": $("#type").val(),
                        "price": $("#price").val(),
                    },
                    dataType: "json",
                    error: function (xhr, textStatus, error) {
                        var response = xhr.responseJSON;
                        if (xhr.status == 422) {
                            $("#title").parents(".form-group").find(".error").html(response.errors.title ? "<span class='text text-danger'>" + response.errors.title + "</span>" : "");
                            $("#location").parents(".form-group").find(".error").html(response.errors.location ? "<span class='text text-danger'>" + response.errors.location + "</span>" : "");
                            $("#about").parents(".form-group").find(".error").html(response.errors.about ? "<span class='text text-danger'>" + response.errors.about + "</span>" : "");
                            $("#featured_event").parents(".form-group").find(".error").html(response.errors.featured_event ? "<span class='text text-danger'>" + response.errors.featured_event + "</span>" : "");
                            $("#language").parents(".form-group").find(".error").html(response.errors.language ? "<span class='text text-danger'>" + response.errors.language + "</span>" : "");
                            $("#foods").parents(".form-group").find(".error").html(response.errors.foods ? "<span class='text text-danger'>" + response.errors.foods + "</span>" : "");
                            $("#departure_date").parents(".form-group").find(".error").html(response.errors.departure_date ? "<span class='text text-danger'>" + response.errors.departure_date + "</span>" : "");
                            $("#duration").parents(".form-group").find(".error").html(response.errors.duration ? "<span class='text text-danger'>" + response.errors.duration + "</span>" : "");
                            $("#type").parents(".form-group").find(".error").html(response.errors.type ? "<span class='text text-danger'>" + response.errors.type + "</span>" : "");
                            $("#price").parents(".form-group").find(".error").html(response.errors.price ? "<span class='text text-danger'>" + response.errors.price + "</span>" : "");
                        }
                    }
                }).done(function (data) {
                    $("#modalTravelPackage").modal("hide");
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: data.message,
                        timer: 2500,
                        showConfirmButton: false,
                    });
                    setTimeout(function () {
                        travelPackageDatatable();
                    }, 2500);
                });
            });
        });

        function travelPackageDatatable() {
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

            var table = $("#table-travel-package").DataTable({
                initComplete: function() {
                    var api = this.api();
                    $('#table-travel-package_filter input')
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
                ajax: '{!! route('travel-package-datatable') !!}',
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'title', name: 'title' },
                    { data: 'location', name: 'location' },
                    { data: 'type', name: 'type' },
                    { data: 'departure_date', name: 'departure_date' },
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