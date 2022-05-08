<?php
include_once "inc/header.php";
Db::changePageToLogin(); ?>
<!--Delete Modal-->
<div class="modal fade" id="deleteDoctorModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">اخطار</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">از حذف فیلد مطمئن هستید ؟</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                <button type="button" class="btn btn-danger" id="delete-doctor-btn" data-id="">حذف</button>
            </div>
        </div>
    </div>
</div>
<!--Appointment Modal-->
<div class="modal fade" id="getAppointmentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row list-app justify-content-center align-items-center"></div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<!--Doctors Form-->
<div class="container-fluid">
    <div class="row m-0 align-items-center">
        <div class="col-xl-2 "><?php include_once "inc/sidebar.php"; ?></div>
        <div class="col-xl-10">
            <div id="doctors">
                <div class="content-body">
                    <div id="message"></div>
                    <table class="table" id="doctor-table">
                        <thead>
                        <tr>
                            <th>تصویر</th>
                            <th>نام</th>
                            <th>نام خانوادگی</th>
                            <th>گروه تخصص</th>
                            <?php if ($_SESSION["user"]["user_type"] === "ادمین"): ?>
                                <th>شماره تماس</th>
                                <th>ایمیل</th>
                                <th>جنسیت</th>
                                <th>روزهای کاری</th>
                                <?php if ($_SESSION["user"]["user_type"] == "مراجعه کننده"): ?>
                                    <th>رزرو نوبت</th>
                                <?php endif; ?>
                            <?php endif; ?>
                            <th>جزئیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $doctors = Doctor::getDoctors();
                        if ($doctors):
                            foreach ($doctors as $row): ?>
                                <tr>
                                    <td><img src="upload/<?php echo $row->doctor_pic ?>" alt=""
                                             class="img-fluid img-rounded"
                                             style="object-fit: cover"></td>
                                    <td><?php echo $row->doctor_name ?></td>
                                    <td><?php echo $row->doctor_lastname ?></td>
                                    <td><?php echo $row->group_name ?></td>
                                    <?php if ($_SESSION["user"]["user_type"] === "ادمین"): ?>
                                        <td><?php echo $row->doctor_phone ?></td>
                                        <td><?php echo $row->doctor_email ?></td>
                                        <td><?php echo $row->doctor_gender ?></td>
                                        <td>
                                            <?php foreach (Work_time::getWorkTimeDoctor($row->doctor_id) as $value) {
                                                echo sprintf("%s از %s تا %s", $value->day, $value->from_hour, $value->to_hour) . "<br>";
                                            } ?>
                                        </td>
                                        <td class="d-flex align-items-center justify-content-around">
                                            <a href="#" class="btn btn-danger delete rounded-circle"
                                               data-id="<?php echo $row->doctor_id ?>" data-toggle="modal"
                                               data-target="#deleteDoctorModal"><span class="icon-bin2"></span></a>
                                            <a href="add_doctor.php?id=<?php echo $row->doctor_id ?>"
                                               class="btn btn-warning rounded-circle"><span class="icon-pencil"></span></a>
                                        </td>
                                    <?php endif; ?>
                                    <?php if ($_SESSION["user"]["user_type"] == "مراجعه کننده"): ?>
                                        <td><a href="#" data-id="<?php echo $row->doctor_id ?>"
                                               class="btn btn-info appointment" data-toggle="modal"
                                               data-target="#getAppointmentModal"><img
                                                        src="images/ic_alarm_white_24dp.png"
                                                        class="ml-1">رزرو نوبت</a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">کاربری یافت نشد</div>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'inc/footer.php' ?>
<script>
    $("#doctor-table").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/fa.json"
        }
    })

    $(document).on("click", ".delete", function (e) {
        e.preventDefault()
        $("#delete-doctor-btn").attr("data-id", $(this).attr("data-id"))
    })
    $("#delete-doctor-btn").on("click", function () {
        $.ajax({
            url: "http://localhost/hospital/ajax_action.php",
            method: "POST",
            data: {page: "doctor", action: "delete_doctor", doctor_id: $(this).attr("data-id")},
            dataType: "json",
            success: function (response) {
                if (response.hasError)
                    $("#message").html("<div class='alert alert-danger'>" + response.msg + "</div>")
                else
                    $("#message").html("<div class='alert alert-success'>" + response.msg + "</div>")

                $("#deleteDoctorModal").modal("hide")
                location.reload()
            }
        })

    })

    let workTimeList
    let doctor_id
    $(document).on("click", ".appointment", function () {
        doctor_id = $(this).attr("data-id")
        $.ajax({
            url: "http://localhost/hospital/ajax_action.php",
            method: "POST",
            data: {page: "appointment", action: "doctor_work_time", doctor_id: $(this).attr("data-id")},
            dataType: "json",
            beforeSend: function () {
                $(".list-app").html("<img class='loading-icon' src='images/Spin-1s-200px%20(1).gif' alt='loading-img'>")
            },
            success: function (response) {
                workTimeList = response.text
                $(".list-app,.modal-header").html("")
                $(response.text).each(function (i, e) {
                    $(".list-app").append(`<div class="col-12 app-item mt-2 bg-white">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-9">
                                    <div class="d-flex justify-content-center align-items-center flex-column app-item-detail">
                                        <span data-date="${e["date_num"]}"> ${e.date}  (${e.day})</span>
                                        <small data-from-hour="${e.from}" data-to-hour="${e.to}">
                                            از ساعت   ${e.from} تا ${e.to}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <span style="font-size: 3rem">&#8592;</span>
                                </div>
                            </div>
                        </div>`)
                })
                $("#getAppointmentModal .modal-footer").html("")
            }
        })
    })

    $(document).on("click", ".app-item", function () {
        let currentAppItem = $(this).find(".app-item-detail span").attr("data-date")
        $.ajax({
            url: "http://localhost/hospital/ajax_action.php",
            method: "POST",
            data: {
                page: "appointment",
                action: "doctor_work_time_item",
                doctor_id: doctor_id,
                date_working: $(this).find("span").attr("data-date"),
                working_time_from: $(this).find("small").attr("data-from-hour"),
                working_time_to: $(this).find("small").attr("data-to-hour"),
            },
            dataType: "json",
            beforeSend: function () {
                $(".list-app").html("<img class='loading-icon' src='images/Spin-1s-200px%20(1).gif' alt='loading-img'>")
            },
            success: function (response) {
                $(".list-app").html(response.text)
                $(".modal-header").html("<select class='form-control' id='app-list'></select>")
                $(workTimeList).each(function (i, e) {
                    if (e["date_num"] === currentAppItem)
                        $("#getAppointmentModal .modal-header select").append(`<option selected value="${e["date_num"]}">${e.date}  (${e.day})</option>`)
                    else
                        $("#getAppointmentModal .modal-header select").append(`<option value="${e["date_num"]}">${e.date}  (${e.day})</option>`)
                })
            }
        })
    })

    $(document).on("click", ".app-item-link", function () {
        $(".list-app").remove("button")
        $.each($(".app-item-link"), function () {
            $(this).removeClass("app-item-link-active")
        })
        $(this).addClass("app-item-link-active")
        $("#getAppointmentModal .modal-footer").html("<button type='button' class='btn btn-block btn-secondary send-app-btn'>تایید</button>")
    })

    $(document).on("click", ".send-app-btn", function () {
        $.ajax({
            url: "http://localhost/hospital/ajax_action.php",
            method: "POST",
            data: {
                page: "appointment",
                action: "add_appointment",
                app_time: $(this).parentsUntil(".modal-dialog").find(".app-item-link-active").text(),
                doctor_id: doctor_id,
                app_date: $(this).parentsUntil(".modal-dialog").find("select").val()
            },
            dataType: "json",
            beforeSend: function () {
                $(".list-app").html("<img class='loading-icon' src='images/Spin-1s-200px%20(1).gif' alt='loading-img'>")
            },
            success: function (response) {
                $("#getAppointmentModal").modal("hide")
                $("#message").html("<div class='alert alert-success'><p>" + response.msg + "</p><p>کد رهگیری : <span class='text-red'>" + response.text + "</span></p></div>")
                $("#getAppointmentModal .modal-footer").html("")
            }
        })
    })

    $(document).on("change", "#getAppointmentModal select", function () {
        let optionEl = $("#getAppointmentModal option:selected").text()
        let day = optionEl.substring(optionEl.indexOf("(") + 1, optionEl.length - 1)
        $.ajax({
            url: "http://localhost/hospital/ajax_action.php",
            method: "POST",
            data: {
                page: "appointment",
                action: "doctor_work_time_item",
                doctor_id: doctor_id,
                date_working: $("#getAppointmentModal option:selected").val(),
                day_working: day,
            },
            dataType: "json",
            beforeSend: function () {
                $(".list-app").html("<img class='loading-icon' src='images/Spin-1s-200px%20(1).gif' alt='loading-img'>")
            },
            success: function (response) {
                $(".list-app").html(response.text)
            }
        })
    })

    $('#getAppointmentModal').on('show', function () {
        $('body').removeClass('modal-open');
    });


</script>