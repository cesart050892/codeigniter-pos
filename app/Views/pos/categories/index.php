<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Categories
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 mt-1 font-weight-bold text-primary">Categories</h6>
            <button type="button" class="btn btn-primary btn-sm" id="btnNewCategory">
                <i class="fas fa-plus-square"></i>
                Add New Category
            </button>
        </div>
        <div class="card-body">
            <table id="tableCategory" class="table table-hover table-bordered table-striped display nowrap" style="width:100%">
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
    const TABLE_APP = $('#tableCategory');

    const MODAL_APP = $('#modalCategory');
    const MODAL_FORM_APP = $('#formCategory');
    const MODAL_TITLE_APP = $('.modal-title');
    const MODAL_SUBMIT_APP = $('.btn-submit');

    //------- DataTable -------------
    var table = TABLE_APP.DataTable({
        "lengthMenu": [
            [3, 5, 10, -1],
            [3, 5, 10, "All"]
        ],
        ajax: {
            type: "GET",
            url: base_url + `api/categories`,
            dataSrc: function(response) {
                return response.data;
            },
        },
        columns: [
            {
                data: "category",
                title: "Category"
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
                $.get(base_url + `api/categories/delete/` + id, () => {
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

    $(`#btnNewCategory`).click(function(e) {
        if (!window.stateFunction) window.stateFunction = true;
        e.preventDefault();
        render({
            title: 'Category',
            btn: 'Save'
        })
    });

    function render(data, option = true) {
        MODAL_APP.modal('show');
        MODAL_TITLE_APP.text('Category')
        !option ? renderUpdate(data) : renderSave(data);
    }

    function renderSave(data = null) {
        MODAL_SUBMIT_APP.text('Save').removeClass('btn-warning').addClass('btn-primary')
        IMG_INPUT_APP.val('')
        IMG_LABEL_APP.text('Choose a image..')
    }

    MODAL_FORM_APP.submit(function(e) {
        e.preventDefault();
        stateFunction ? ajaxSave(this) : ajaxUpdate(this);
    });

    function ajaxSave(data) {
        $.ajax({
            type: "POST",
            url: base_url + `api/categories`,
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
        $.get(base_url + 'api/categories/edit/' + id, (response) => {
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
            url: base_url + "/api/categories/update/" + id,
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
<div class="modal fade" id="modalCategory" tabindex="-1" role="dialog" aria-labelledby="labelModalCategory" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelModalCategory"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" id="formCategory">
                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                </div>
                                <input id="inputCategory" name="category" type="text" class="form-control">
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