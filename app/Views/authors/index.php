<?= $this->extend('template/admin_template'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Author Management</h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <button type="button" id="addrow" data-toggle="modal" data-target="#modelId" class="btn btn-primary" onclick="clearform()">
                    Add Author
                </button>
            </div>
        </div>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">LAST NAME</th>
                    <th scope="col">FIRST NAME</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">BIRTHDATE</th>
                    <th scope="col">ACTIONS</th>
                </tr>
            </thead>
        </table>

        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Author</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" novalidate>
                            <input type="hidden" name="id" id="id" />
                            <div class="form-group">
                                <label for="last_name">Last Name *</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required />
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter a Last Name.</div>
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name *</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" required />
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter a First Name.</div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="test@email.com" required />
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter a Email.</div>
                            </div>
                            <div class="form-group">
                                <label for="birthdate">Birth Date: *</label>
                                <div class="input-group date" id="birthdatepicker" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#birthdatepicker" name="birthdate" id="birthdate" required />
                                    <div class="input-group-append" data-target="#birthdatepicker" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary" id="save">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="deleteprompt" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            You are about to delete this record with ID
                            <span id="itemtodelete"></span>.
                        </p>
                        <input type="hidden" id="deleteid" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary" onclick="deleteProfile()">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('pagescripts'); ?>
<script>
    $(function() {
        //Date picker
        $('#birthdatepicker').datetimepicker({
            format: 'YYYY-MM-DD',
        });

        $("form").submit(function(event) {
            event.preventDefault();
            let formdata = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            let jsondata = JSON.stringify(formdata);

            if (this.checkValidity()) {
                if (!formdata.id) {
                    //create
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url() ?>authors",
                        data: jsondata,
                        success: function(result, textStatus, jqXHR) {
                            console.log(textStatus + ": " + jqXHR.status);
                            $(document).Toasts("create", {
                                class: "bg-success",
                                title: "Success",
                                body: "Records Created Successfuly.",
                                autohide: true,
                                delay: 3000,
                            });
                            clearform();
                            table.ajax.reload();
                            $("#modelId").modal("hide");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + ": " + jqXHR.status + " " + errorThrown);
                            $(document).Toasts("create", {
                                class: "bg-danger",
                                title: "Error",
                                body: "Records Was Not Created.",
                                autohide: false,
                                delay: 3000,
                            });
                        },
                    });
                } else {
                    //update
                    $.ajax({
                        method: "PUT",
                        url: "<?= base_url() ?>authors/" + formdata.id,
                        data: jsondata,
                        success: function(result, textStatus, jqXHR) {
                            console.log(textStatus + ": " + jqXHR.status);
                            $(document).Toasts("create", {
                                class: "bg-success",
                                title: "Success",
                                body: "Records Updated Successfuly.",
                                autohide: true,
                                delay: 3000,
                            });
                            clearform();
                            table.ajax.reload();
                            $("#modelId").modal("hide");

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + ": " + jqXHR.status + " " + errorThrown);
                            $(document).Toasts("create", {
                                class: "bg-danger",
                                title: "Error",
                                body: "Records Was Not Updated.",
                                autohide: true,
                                delay: 3000,
                            });
                        },
                    });
                }
                $(this).addClass("was-validated");
            }


        });

        $(document).on("click", "#editRow", function() {
            let row = $(this).parents("tr")[0];
            let id = table.row(row).data().id;
            $.ajax({
                method: "GET",
                url: "<?= base_url() ?>authors/" + id,
                success: function(result, textStatus, jqXHR) {
                    console.log(textStatus + ": " + jqXHR.status);
                    $("#modelId").modal("show");
                    $("#id").val(result.id);
                    $("#last_name").val(result.last_name);
                    $("#first_name").val(result.first_name);
                    $("#email").val(result.email);
                    $("#birthdate").val(result.birthdate);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus + ": " + jqXHR.status + " " + errorThrown);
                },
            });
        });

        $(document).on("click", "#deleteRow", function() {
            let row = $(this).parents("tr")[0];
            let id = table.row(row).data().id;
            $("#deleteid").val(id);
            $("#itemtodelete").text(id);
            $("#deleteprompt").modal("show");
        });
    });

    var table = $("#dataTable").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url() ?>authors/list",
            type: "POST",
        },
        columns: [{
                data: "id"
            },
            {
                data: "last_name"
            },
            {
                data: "first_name"
            },
            {
                data: "email"
            },
            {
                data: "birthdate"
            },
            {
                data: null,
                defaultContent: `<td>
                <button class="btn btn-primary" id="editRow">Edit</button>
                <button class="btn btn-danger" data-toggle="modal" id="deleteRow">Delete</button>
              </td>`,
            },
        ],
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        lengthMenu: [5, 10, 25, 50],
    });

    function deleteProfile() {
        $("#deleteprompt").modal("hide");
        let id = $("#deleteid").val();
        $.ajax({
            method: "DELETE",
            url: "<?= base_url() ?>authors/" + id,
            success: function(result, textStatus, jqXHR) {
                console.log(textStatus + ": " + jqXHR.status);
                $(document).Toasts("create", {
                    class: "bg-success",
                    title: "Success",
                    body: "Records Deleted Successfuly.",
                    autohide: true,
                    delay: 3000,
                });
                table.ajax.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus + ": " + jqXHR.status + " " + errorThrown);
            },
        });
    }

    function clearform() {
        $("#id").val("");
        $("#last_name").val("");
        $("#first_name").val("");
        $("#email").val("");
        $("#birthdate").val("");
    }

    $(document).ready(function() {
        'use strict';
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = $('.needs-validation');
        // Loop over them and prevent submission
        forms.each(function() {
            $(this).on('submit', function(event) {
                if (this.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                $(this).addClass('was-validated');
            });
        });
    });
</script>
<?= $this->endSection(); ?>