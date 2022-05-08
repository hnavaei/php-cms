<?php include_once "inc/header.php" ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4">
                <div id="message"></div>
                <div class="login">
                    <?php if (isset($_GET["role"])) : ?>
                        <h4>ورود به عنوان <?php echo ($_GET["role"] == 1) ? "ادمین" : "پزشک" ?></h4>
                        <form id="login-form" method="post" data-parsley-validate>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-sm">ایمیل</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email-login" data-parsley-required
                                           data-parsley-error-message="این فیلد ضروری است">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label col-form-label-sm">پسورد</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password-login"
                                           data-parsley-required data-parsley-error-message="این فیلد ضروری است">
                                </div>
                            </div>
                            <input type="hidden" name="role" value="<?php echo $_GET["role"] ?>">
                            <input type="submit" name="login" value="ورود" class="btn btn-info">
                        </form>
                    <?php else: ?>
                        <h4>ورود به عنوان:</h4>
                        <div class="row align-items-center justify-content-center">
                            <div class="col-4 text-center img-login-wrapper">
                                <div class="mb-1"><img src="images/admin-logo.png" alt="">
                                </div>
                                <a href="?role=1" class="btn btn-info">ادمین</a>
                            </div>
                            <div class="col-4 text-center img-login-wrapper">
                                <div class="mb-1"><img
                                            src="images/doctor-logo.png"
                                            alt=""></div>
                                <a href="?role=2" class="btn btn-info">پزشک</a>
                            </div>
                            <div class="col-4 text-center img-login-wrapper">
                                <div class="mb-1"><img src="images/patient-logo.png"
                                                       alt=""></div>
                                <a href="login_patient.php" class="btn btn-info">بیمار</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once 'inc/footer.php' ?>
<script>
    const loginForm = $("#login-form")
    $(function () {
        loginForm.parsley()
        loginForm.on("submit", function (e) {
            e.preventDefault()
            if ($("#login-form").parsley().isValid()) {
                $.ajax({
                    url: "http://localhost/hospital/ajax_action.php",
                    method: "POST",
                    data: $(this).serialize() + "&action=login&page=login",
                    dataType: "json",
                    success: function (data) {
                        if (!data.hasError) window.location.href = "http://localhost/hospital/index.php";
                        else $("#message").html("<p class='alert-danger alert'>" + data.msg + "</p>")
                    }
                })
            }
        })
    })
</script>
