<?= $this->extend('layout/auth') ?>

<?= $this->section('title') ?>
Login
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Outer Row -->
<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Sign in!</h1>
                            </div>
                            <form class="user">
                                <div class="form-group">
                                    <input type="user" name="username" class="form-control form-control-user" id="exampleInputUser" aria-describedby="userHelp" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">Remember
                                            Me</label>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block" type="submit">Login</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="register.html">Create an Account!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- End Outer Row -->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(function() {
        var base_url = window.location.origin + '/';
        $('form').submit(function(e) {
            e.preventDefault();
            userData = $(this).serialize()
            $.ajax({
                type: "POST",
                url: base_url + 'api/auth/login',
                data: userData,
                success: function(response) {
                    window.location = 'dashboard'
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR.responseJSON.messages.error == 'not access'){
                        Swal.fire(
                        'Error!',
                        'you are not allowed to enter!',
                        'error'
                    )
                    }else{
                        Swal.fire(
                        'Error!',
                        'user or password does not match!',
                        'error'
                    )
                    }

                }
            });
        });
    });
</script>
<?= $this->endSection() ?>