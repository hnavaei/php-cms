<?php
include_once "inc/header.php";
Db::changePageToLogin();
$isEdit = false;
if (isset($_GET["id"]) and !empty($_GET["id"])) {
    $isEdit = true;
    $doctor = Doctor::getDoctorWithId($_GET["id"]);
    $doctor_work_time = Work_time::getWorkTimeDoctor($_GET["id"]);
}
?>
<!--Doctor Add And Edit Form-->
<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-xl-2"><?php include_once "inc/sidebar.php"; ?></div>
        <div class="col-xl-10">
            <div id="add-doctor">
                <div class="row align-items-center justify-content-around">
                    <div class="col-lg-8">
                        <div class="content-body">
                            <div id="message"></div>
                            <form action="" id="add-doctor-form" enctype="multipart/form-data" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">نام پزشک</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="doctor-firstname"
                                               value="<?php echo $isEdit ? $doctor->doctor_name : "" ?>"
                                               name="doctor-firstname">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">نام خانوادگی پزشک</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="doctor-lastname"
                                               name="doctor-lastname"
                                               value="<?php echo $isEdit ? $doctor->doctor_lastname : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">گروه تخصص پزشک</label>
                                    <div class="col-sm-9">
                                        <select name="doctor-group" id="doctor-group" class="form-control">
                                            <option value="">گروه تخصص پزشک را انتخاب کنید</option>
                                            <?php foreach (Group::getGroups() as $group): ?>
                                                <option value="<?php echo $group->group_id ?>" <?php if ($isEdit and $group->group_id == $doctor->doctor_group) echo "selected" ?>><?php echo $group->group_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">ایمیل پزشک</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="doctor-email"
                                               name="doctor-email"
                                               value="<?php echo $isEdit ? $doctor->doctor_email : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">شماره تماس پزشک</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="doctor-phone1"
                                               name="doctor-phone"
                                               value="<?php echo $isEdit ? $doctor->doctor_phone : "" ?>">
                                    </div>
                                </div>
                                <?php if ($isEdit): ?>
                                    <?php $i = 0;
                                    foreach ($doctor_work_time as $work_time):
                                        $i++
                                        ?>
                                        <input type="hidden" value="<?php echo $work_time->id ?>" name="work-time-id<?php echo $i ?>">
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">روز کاری</label>
                                            <div class="col-9">
                                                <select name="work-day-doctor<?php echo $i ?>" id="work-day-doctor1"
                                                        class="form-control">
                                                    <option value="<?php echo $work_time->day ?>"
                                                            selected><?php echo $work_time->day ?></option>
                                                    <option value="شنبه">شنبه</option>
                                                    <option value="یکشنبه">یکشنبه</option>
                                                    <option value="دوشنبه">دوشنبه</option>
                                                    <option value="سه شنبه">سه شنبه</option>
                                                    <option value="چهارشنبه">چهارشنبه</option>
                                                    <option value="پنجشنبه">پنجشنبه</option>
                                                    <option value="جمعه">جمعه</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row work-time">
                                            <label class="col-3 col-form-label">ساعت کاری از</label>
                                            <div class="col-4">
                                                <input type="time" class="form-control"
                                                       name="work-time-doctor-from<?php echo $i ?>"
                                                       value="<?php echo $work_time->from_hour ?>">
                                            </div>
                                            <label class="col-1 col-form-label text-center">تا</label>
                                            <div class="col-4">
                                                <input type="time" class="form-control"
                                                       name="work-time-doctor-to<?php echo $i ?>"
                                                       value="<?php echo $work_time->to_hour ?>">
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">روز کاری</label>
                                        <div class="col-9">
                                            <select name="work-day-doctor1" id="work-day-doctor1" class="form-control">
                                                <option value="شنبه">شنبه</option>
                                                <option value="یکشنبه">یکشنبه</option>
                                                <option value="دوشنبه">دوشنبه</option>
                                                <option value="سه شنبه">سه شنبه</option>
                                                <option value="چهارشنبه">چهارشنبه</option>
                                                <option value="پنجشنبه">پنجشنبه</option>
                                                <option value="جمعه">جمعه</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row work-time">
                                        <label class="col-3 col-form-label">ساعت کاری از</label>
                                        <div class="col-4">
                                            <input type="time" class="form-control" name="work-time-doctor-from1">
                                        </div>
                                        <label class="col-1 col-form-label text-center">تا</label>
                                        <div class="col-4">
                                            <input type="time" class="form-control" name="work-time-doctor-to1">
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">جنسیت پزشک</label>
                                    <div class="col-sm-9">
                                        <?php if (!$isEdit): ?>
                                            <label>
                                                <input type="radio" name="doctor-gender" value="خانم">خانم
                                            </label>
                                            <label>
                                                <input type="radio" name="doctor-gender" value="آقا">آقا
                                            </label>
                                        <?php else: ?>
                                            <input type="text" class="form-control" readonly
                                                   value="<?php echo $doctor->doctor_gender ?>">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">تصویر</label>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" id="doctor-pic" name="doctor-pic"
                                                   class="custom-file-input">
                                            <label class="custom-file-label">تصویر</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-left">
                                    <input type="hidden" name="page" value="doctor">
                                    <input type="submit" name="doctor-btn" id="doctor-btn"
                                           value="<?php echo !$isEdit ? "اضافه کردن" : "ویرایش" ?>"
                                           class="btn btn-info">
                                    <?php if (!$isEdit): ?>
                                        <button type="button" id="add-work-time" class="btn bg-org text-white">اضافه
                                            کردن ساعت کاری
                                        </button>
                                    <?php endif; ?>
                                    <?php echo !$isEdit ? '<input type="hidden" name="action" value="add_doctor">' : '<input type="hidden" name="action" value="edit_doctor"><input type="hidden" name="doctor-id" value="' . $_GET["id"] . '" >' ?>
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
    const doctorBtn = $("#doctor-btn"),
        addDoctorForm = $("#add-doctor-form"),
        addWorkTimeBtn = $("#add-work-time"),
        msg = $("#message")

    addDoctorForm.parsley()
    $("#add-doctor-form input:not([type='radio'])").attr("data-parsley-required", "true").attr("data-parsley-error-message", "این فیلد الزامی است")
    addDoctorForm.on("submit", function (e) {
            e.preventDefault()
            if ($(this).parsley().isValid()) {
                $.ajax({
                    url: "http://localhost/hospital/ajax_action.php",
                    method: "POST",
                    data: new FormData(document.getElementById("add-doctor-form")),
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function () {
                        doctorBtn.attr("disabled", "disabled")
                        doctorBtn.val("در حال ارسال...")
                    },
                    success: function (response) {
                        console.log(response)
                        if (response.hasError)
                            msg.html("<div class='alert alert-danger'>" + response.msg + "</div>")
                        else
                            msg.html("<div class='alert alert-success'>" + response.msg + "</div>")

                        doctorBtn.attr("disabled", false)
                        doctorBtn.val("ارسال")
                        addDoctorForm[0].reset()
                        addDoctorForm.parsley().reset()
                    }
                })
            }
        }
    )


    let i = 1;
    addWorkTimeBtn.click(function () {
        ++i
        $(".work-time").last().after(`<div class="form-group row">
                                    <label class="col-3 col-form-label">روز کاری دیگر</label>
                                    <div class="col-9">
                                        <select name="work-day-doctor${i}" class="form-control">
                                            <option value="شنبه">شنبه</option>
                                            <option value="یکشنبه">یکشنبه</option>
                                            <option value="دوشنبه">دوشنبه</option>
                                            <option value="سه شنب">سه شنبه</option>
                                            <option value="چهارشنبه">چهارشنبه</option>
                                            <option value="چهارشنبه">پنجشنبه</option>
                                            <option value="چهارشنبه">جمعه</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row work-time">
                                    <label class="col-3 col-form-label">ساعت کاری از</label>
                                    <div class="col-4">
                                        <input type="time" class="form-control" name="work-time-doctor-from${i}">
                                    </div>
                                    <label class="col-1 col-form-label text-center">تا</label>
                                    <div class="col-4">
                                        <input type="time" class="form-control" name="work-time-doctor-to${i}">
                                    </div>
                                </div>`)
    })
</script>