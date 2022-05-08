<?php require_once "inc/header.php"; ?>
<?php
Db::changePageToLogin();
$isEdit = false;
if (isset($_GET["id"]) and !empty($_GET["id"])) {
    $isEdit = true;
    $patient = Patient::getPatientWithId($_GET["id"]);
}
?>
<!--Patient Add And Edit Form-->
<div class="container-fluid">
    <div class="row m-0 align-items-center">
        <div class="col-xl-2"><?php include_once "inc/sidebar.php"; ?></div>
        <div class="col-xl-10">
            <div id="add-doctor">
                <div class="row align-items-center justify-content-around">
                    <div class="col-lg-8">
                        <div class="content-body">
                            <div id="message"></div>
                            <form action="" id="add-patient-form" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">نام بیمار</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="patient-firstname"
                                               value="<?php echo $isEdit ? $patient->patient_name : "" ?>"
                                               name="patient-firstname">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">نام خانوادگی بیمار</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="patient-lastname"
                                               name="patient-lastname"
                                               value="<?php echo $isEdit ? $patient->patient_lastname : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">سن بیمار</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="patient-age" id="patient-age" class="form-control"
                                               value="<?php echo $isEdit ? $patient->patient_age : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">ایمیل بیمار</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="patient-email"
                                               name="patient-email"
                                               value="<?php echo $isEdit ? $patient->patient_email : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">شماره تماس بیمار</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="patient-phone"
                                               name="patient-phone"
                                               value="<?php echo $isEdit ? $patient->patient_phone : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">جنسیت بیمار</label>
                                    <div class="col-sm-9">
                                        <?php if (!$isEdit): ?>
                                            <label>
                                                <input type="radio" name="patient-gender" value="خانم">خانم
                                            </label>
                                            <label>
                                                <input type="radio" name="patient-gender" value="آقا">آقا
                                            </label>
                                        <?php else: ?>
                                            <input type="text" class="form-control" readonly
                                                   value="<?php echo $patient->patient_gender ?>">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">اطلاعات بیمار</label>
                                    <div class="col-sm-9">
                                        <textarea name="patient-info" rows="5"
                                                  class="form-control"><?php echo $isEdit ? $patient->patient_info : " " ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group text-left">
                                    <input type="hidden" name="page" value="patient">
                                    <?php echo !$isEdit ? '<input type="submit" name="add-patient-btn" id="patient-btn" value="اضافه کردن" class="btn btn-info"><input type="hidden" name="action" value="add_patient">' : '<input type="submit" name="edit-patient-btn" id="patient-btn" value="ویرایش" class="btn btn-info"><input type="hidden" name="action" value="edit_patient"><input type="hidden" name="patient-id" value="' . $_GET["id"] . '" >' ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 d-lg-block d-none">
                        <img src="images/background-two-right.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'inc/footer.php' ?>

<script>
    const addPatientForm = $("#add-patient-form"),
        patientBtn = $("#patient-btn"),
        msg = $("#message")
    addPatientForm.parsley()
    $("#add-patient-form input:not([type='radio'])").attr("data-parsley-required", "true").attr("data-parsley-error-message", "این فیلد الزامی است")
    $("#doctor-phone").attr("data-parsley-length", "11")
    addPatientForm.on("submit", function (e) {
        e.preventDefault()
        if ($(this).parsley().isValid()) {
            $.ajax({
                url: "http://localhost/hospital/ajax_action.php",
                method: "POST",
                data: addPatientForm.serialize(),
                dataType: "json",
                beforeSend: function () {
                    patientBtn.attr("disabled", "disabled")
                    patientBtn.val("در حال ارسال...")
                },
                success: function (response) {
                    if (response.hasError)
                        msg.html("<div class='alert alert-danger'>" + response.msg + "</div>")
                    else
                        msg.html("<div class='alert alert-success'>" + response.msg + "</div>")
                    patientBtn.attr("disabled", false)
                    patientBtn.val("ارسال")
                    addPatientForm[0].reset()
                    addPatientForm.parsley().reset()
                },
                error: function () {
                    alert('error')
                }
            })
        }
    })
</script>
