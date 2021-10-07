<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Clients
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 mt-1 font-weight-bold text-primary">Clients</h6>
            <button type="button" class="btn btn-primary btn-sm" id="btnNewClients">
                <i class="fas fa-plus-square"></i>
                Add New Clients
            </button>
        </div>
        <div class="card-body">
            <table id="tableClients" class="table table-hover table-bordered table-striped display nowrap" style="width:100%">
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<?= $this->endSection() ?>

<?= $this->section('plugins-js') ?>
<!-- DataTables  & Plugins -->
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables-min/js/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables-min/js/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables-min/js/datatables.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('plugins-css') ?>
<!-- DataTables-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables-min/css/datatables.min.css') ?>" />
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    const ENTITY_API = 'Clients';
    const TABLE_APP = $('#tableClients');

    const MODAL_APP = $('#modalClients');
    const MODAL_FORM_APP = $('#formClients');
    const MODAL_TITLE_APP = $('.modal-title');
    const MODAL_SUBMIT_APP = $('.btn-submit');

    const IMG_THUMB_APP = $('#thumbsImageClients');
    const IMG_LABEL_APP = $('#labelFileClients');
    const IMG_INPUT_APP = $('#customFileClients')

    IMG_INPUT_APP.change(function() {
        image = this.files[0]
        name = image['name']
        type = image['type']
        size = image['size']
        formats = ['image/jpeg', 'image/png', 'application/pdf']
        //return console.log(name)
        if (type != formats[0] && type != formats[1] && type != formats[2]) {
            IMG_INPUT_APP.val('')
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong with the format!'
            })
        } else if (size > 2000000) {
            IMG_INPUT_APP.val('')
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong with size!'
            })
        } else {
            var img = new FileReader
            img.readAsDataURL(image)
            $(img).on('load', function(e) {
                var route = e.target.result
                IMG_THUMB_APP.attr('src', route)
                IMG_LABEL_APP.text(name)
            })
        }
    })

    //------- DataTable -------------
    var table = TABLE_APP.DataTable({
        "lengthMenu": [
            [3, 5, 10, -1],
            [3, 5, 10, "All"]
        ],
        ajax: {
            type: "GET",
            url: base_url + `api/${ENTITY_API}`,
            dataSrc: function(response) {
                return response.data;
            },
        },
        columns: [
            {
                data: "name",
                title: "Fullname"
            },
            {
                data: "email",
                title: "Email"
            },
            {
                data: "phone",
                title: "Phone"
            },
            {
                data: "address",
                title: "Address"
            },
            {
                data: null,
                title: "Actions",
                render: function(data) {
                    return `
          <div class='text-center'>
            <button class='btn btn-warning btn-sm' onClick="edit(${data.id})">
                <i class="fas fa-edit"></i>
            </button>
            <button class='btn btn-danger btn-sm' onClick="destroy(${data.id})">
                <i class="fas fa-trash"></i>
            </button>
          </div>`;
                },
            },
        ],
        columnDefs: [{
            className: "text-center",
            targets: "_all",
        }, ],
        responsive: true,
    });

    /*
         setInterval(function() {
            table.ajax.reload();
        }, 1000); 
    */

    function destroy(id) {
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get(base_url + `api/${ENTITY_API}/delete/` + id, () => {
                    table.ajax.reload(null, false);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been deleted',
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
            }
        })
    }

    $(`#btnNewClients`).click(function(e) {
        if (!window.stateFunction) window.stateFunction = true;
        e.preventDefault();
        render({
            title: 'Clients',
            btn: 'Save'
        })
    });

    function render(data, option = true) {
        MODAL_APP.modal('show');
        MODAL_TITLE_APP.text('Clients');
        !option ? renderUpdate(data) : renderSave(data);
    }

    function renderSave(data = null) {
        MODAL_SUBMIT_APP.text('Save').removeClass('btn-warning').addClass('btn-primary')
        MODAL_FORM_APP.trigger("reset");
    }

    MODAL_FORM_APP.submit(function(e) {
        e.preventDefault();
        stateFunction ? ajaxSave(this) : ajaxUpdate(this);
    });

    function ajaxSave(data) {
        $.ajax({
            type: "POST",
            url: base_url + `api/${ENTITY_API}`,
            data: new FormData(data),
            processData: false,
            contentType: false,
            success: function(response) {
                renderSave();
                table.ajax.reload();
                MODAL_APP.modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 2000
                })
            },
            error: function(err, status, thrown) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error when saving, check your data.',
                    showConfirmButton: false,
                    timer: 3000
                })
            }
        });
    }

    function edit(id) {
        window.stateFunction = false
        $.get(base_url + `api/${ENTITY_API}/edit/` + id, (response) => {
            sessionStorage.setItem('idupdate', id)
            render({
                    result: response.data,
                    btn: 'Update'
                },
                false
            );
        });
    }

    function renderUpdate(data) {
        MODAL_SUBMIT_APP.text(data.btn).removeClass('btn-primary').addClass('btn-warning')
    }

    function ajaxUpdate(data) {
        var data = new FormData(data)
        var id = sessionStorage.getItem('idupdate')
        data.delete('password')
        data.append('id', id);
        $.ajax({
            type: "POST",
            url: base_url + `api/${ENTITY_API}/update/` + id,
            data: data,
            processData: false,
            contentType: false,
            success: function(response) {
                renderSave()
                sessionStorage.removeItem('idupdate')
                table.ajax.reload();
                MODAL_APP.modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been updated',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        });
    }
</script>
<?= $this->endSection() ?>


<?= $this->section('modal') ?>
<!-- Modal -->
<div class="modal fade" id="modalClients" tabindex="-1" role="dialog" aria-labelledby="labelModalClients" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelModalClients"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" id="formClients">
                    <!-- ENTRADA PARA EL CÓDIGO -->
                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="identification" name="identification" placeholder="Identification">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="birthdate" name="birthdate" placeholder="Birthdate">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button name="submit" type="submit" class="btn btn-primary btn-submit"></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<i class="fa fa-percent"></i>

<!-- CHECKBOX PARA PORCENTAJE -->
<div class="col-xs-6">
    <div class="form-group">
        <label>
            <input type="checkbox" class="minimal porcentaje" checked>
            Utilizar procentaje
        </label>
    </div>
</div>
<!-- ENTRADA PARA PORCENTAJE -->
<div class="col-xs-6" style="padding:0">
    <div class="input-group">
        <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
    </div>
</div>