<?php
include_once "inc/header.php";
include_once "include.php";
Db::changePageToLogin();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-2"><?php include_once "inc/sidebar.php" ?></div>
        <div class="col-xl-10">
            <div id="profile">
                <div class="row align-items-center justify-content-around mt-5">
                    <div class="col-lg-8">
                        <div class="content-body">
                            <div id="message"></div>
                            <form action="" id="change-pwd-form">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">پسورد قدیمی</label>
                                    <div class="col-sm-9 position-relative">
                                        <span class="icon-eye ico"></span>
                                        <input type="password" class="form-control" id="old-pass" name="old-pass">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">رمز عبور جدید</label>
                                    <div class="col-sm-9 position-relative">
                                        <span class="icon-eye ico"></span>
                                        <input type="password" class="form-control" id="new-pass" name="new-pass">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">تایید عبور جدید</label>
                                    <div class="col-sm-9 position-relative">
                                        <span class="icon-eye ico"></span>
                                        <input type="password" class="form-control" id="confirm-new-pass"
                                               name="confirm-new-pass" data-parsley-equalto="#new-pass"
                                               data-parsley-error-message="تایید پسورد یکسان نیست">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="page" value="pwd">
                                    <input type="hidden" name="action" value="change-pwd">
                                    <input type="submit" class="btn-info btn" id="btn-change-pwd"
                                           name="btn-change-pwd"
                                           value="اعمال تغییرات">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block">
                        <img src="images/background-two-right.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'inc/footer.php' ?>
<script>
    $(".ico").click(function () {
        if ($(this).next(".form-control").attr("type") === "password") {
            $(this).next(".form-control").attr("type", "text")
            $(this).css({opacity: 1})
        } else {
            $(this).next(".form-control").attr("type", "password")
            $(this).css({opacity: .5})
        }
    })
    $("#change-pwd-form").parsley()
    $("#change-pwd-form input").attr("required", "required").attr("data-parsley-error-message", "این فیلد الزامی است")
    $("#change-pwd-form").on("submit", function (e) {
        e.preventDefault()
        if ($("#change-pwd-form").parsley().isValid()) {
            $.ajax({
                url: "http://localhost/hospital/ajax_action.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function (data) {
                    if (!data.hasError) $("#message").html("<p class='alert-success alert'>" + data.msg + "</p>");
                    else $("#message").html("<p class='alert-danger alert'>" + data.msg + "</p>")
                    $("#change-pwd-form")[0].reset()
                }
            })
        }
    })
</script>


