<?php include_once "inc/header.php" ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4">
                <div id="alert"></div>
            </div>
            <div class="col-12">
                <div class="login">
                    <h4>دستیابی به اطلاعات بیمار </h4>
                    <form id="login-patient-form" method="post" data-parsley-validate class="w-50">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">ایمیل بیمار</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="patient-email" data-parsley-required
                                       data-parsley-error-message="این فیلد ضروری است">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">کد بیمار</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="patient-num"
                                       data-parsley-required data-parsley-error-message="این فیلد ضروری است">
                            </div>
                        </div>
                        <input type="hidden" name="role" value="3">
                        <input type="hidden" name="page" value="login">
                        <input type="hidden" name="action" value="patient_login">
                        <input type="submit" name="login" value="ورود" class="btn btn-info" id="patient-login-btn">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once 'inc/footer.php' ?>
<script>
    const loginPatientForm = $("#login-patient-form"),
        loginPatientBtn = $("#patient-login-btn")
    loginPatientForm.parsley()
    loginPatientForm.on("submit", function (e) {
        e.preventDefault()
        if ($(this).parsley().isValid()) {
            $.ajax({
                url: "http://localhost/hospital/ajax_action.php",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    loginPatientBtn.attr("disabled", "disabled")
                    loginPatientBtn.val("در حال ارسال")
                },
                success: function (response) {
                    if (!response.hasError)
                        window.location.href = "http://localhost/hospital/index.php"
                    else
                        $("#alert").html("<p class='alert-danger alert'>" + response.msg + "</p>")
                    loginPatientBtn.attr("disabled", false)
                    loginPatientBtn.val("ارسال")
                }
            })
        }

    })
</script>
