<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Users
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 mt-1 font-weight-bold text-primary">Users</h6>
            <button type="button" class="btn btn-primary btn-sm" id="btn-new-users">
                <i class="fas fa-plus-square"></i>
                Add New Users
            </button>
        </div>
        <div class="card-body">
            <table id="users" class="table table-hover table-bordered table-striped display nowrap" style="width:100%">
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
    $('.custom-file-input').change(function() {
        image = this.files[0]
        name = image['name']
        type = image['type']
        size = image['size']
        formats = ['image/jpeg', 'image/png', 'application/pdf']
        //return console.log(name)
        if (type != formats[0] && type != formats[1] && type != formats[2]) {
            $('.custom-file-input').val('')
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong with the format!'
            })
        } else if (size > 2000000) {
            $('.custom-file-input').val('')
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
                $('#imgThumb').attr('src', route)
                $('.custom-file-label').text(name)
            })
        }
    })

    $('#btn-new-users').click(function(e) {
        if (!window.stateFunction) window.stateFunction = true;
        e.preventDefault();
        render({
            title: 'User',
            btn: 'Save'
        })
    });

    function render(data, option = true) {
        $('#usersModal').modal('show');
        !option ? renderUpdate(data) : renderSave(data);
    }

    function renderSave(data) {
        $('.modal-title').text(data.title)
        $('.btn-submit').text(data.btn)
        $('#input-type').val(null).trigger('change');
        $('#input-account').val('')
        $('#input-code').val('')
    }
</script>
<?= $this->endSection() ?>

<?= $this->section('modal') ?>

<!-- Modal -->
<div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersModalLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="usersModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <input id="user-name" name="user-name" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-key"></i>
                                    </div>
                                </div>
                                <input id="user-email" name="user-email" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                </div>
                                <input id="user-password" name="user-password" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01">
                            <option selected>Choose...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="form-group">
              

              <div class="custom-file">
                        <input accept="image/*" type="file" class="custom-file-input" id="fImage" name="image">
                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                    </div>
              <p class="help-block pl-2">Max. size 2MB</p>
              <img src="assets/img/undraw_profile_2.svg" id="imgThumb" class="rounded mx-auto d-block" alt="Responsive image" style="width:100px">
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