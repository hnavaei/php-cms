<?php
include_once "inc/header.php";
Db::changePageToLogin();
?>
<!--Delete Modal-->
<div class="modal fade" id="printModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 class="text-center">هو الشافی</h6>
                <h6 class="text-center">درمانگاه تخصصی و فوق تخصصی ...</h6>
                <div class="row mt-4" id="print-patient-detail">
                    <div class="col-6">نام بیمار: آقای/خانم</div>
                    <div class="col-6 info" id="patient-name"></div>
                    <div class="col-6">گروه تخصص:</div>
                    <div class="col-6 info" id="dr-group"></div>
                    <div class="col-6">نام پزشک:</div>
                    <div class="col-6 info" id="dr-name"></div>
                    <div class="col-6">تاریخ:</div>
                    <div class="col-6 info" id="date"></div>
                    <div class="col-6">ساعت حضور:</div>
                    <div class="col-6 info" id="hour"></div>
                    <div class="col-6"> شیفت:</div>
                    <div class="col-6 info" id="shift"></div>
                    <div class="col-6"> کد رهگیری:</div>
                    <div class="col-6 info" id="code"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success d-block w-100" id="delete-doctor-btn"
                        onclick="window.print()">چاپ
                </button>
            </div>
        </div>
    </div>
</div>
<!--Appointment Reserved Form-->
<div class="container-fluid">
    <div class="row m-0 align-items-center">
        <div class="col-xl-2"><?php include_once "inc/sidebar.php"; ?></div>
        <div class="col-xl-10">
            <div id="appointment-reserved">
                <div class="content-body">
                    <table class="table" id="appointment-reserved-table">
                        <thead>
                        <tr>
                            <th>ریف</th>
                            <th>نام بیمار</th>
                            <th>گروه تخصص</th>
                            <th>پزشک</th>
                            <th>تاریخ</th>
                            <th>ساعت حضور</th>
                            <th>کد رهگیری</th>
                            <th>جزئیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        $apps = ($_SESSION["user"]["user_type"] === "پزشک") ? Appointment::getAppWithDrId($_SESSION["user"]["user_id"]) : Appointment::getAllApp();
                        if ($apps):
                            foreach ($apps as $row): ?>
                                <?php if ($_SESSION["user"]["user_username"] == $row->patient): ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td data-info="patient-name"><?php echo $row->patient ?></td>
                                        <td data-info="dr-group"><?php echo $row->doctor_group ?></td>
                                        <td data-info="dr-name">
                                            <?php
                                            switch ($row->doctor_gender) {
                                                case "خانم":
                                                    echo "خانم دکتر $row->doctor";
                                                    break;
                                                case "آقا":
                                                    echo "آقای دکتر $row->doctor";
                                            }
                                            ?>
                                        </td>
                                        <td data-info="date"><?php echo $row->in_date ?></td>
                                        <td data-info="hour"><?php echo $row->in_hour ?></td>
                                        <td data-info="code"><?php echo $row->code ?></td>
                                        <td>
                                            <a href="" class="btn btn-info print-btn"
                                               data-id="<?php echo $row->patient_id ?>" data-toggle="modal"
                                               data-target="#printModal">پرینت</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
    $("#appointment-reserved-table").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/fa.json"
        }
    })

    $(document).on("click", ".print-btn", function () {
        let arrPatient = Object
        $.each($(this).parent().parent().find("td"), function () {
            if ($(this).attr("data-info"))
                arrPatient[$(this).attr("data-info")] = $(this).text().trim()
        })

        for (let [key, value] of Object.entries(arrPatient))
            $("#" + key + "").text(value)
        $("#shift").html(witchTime($("#hour").text()))
    })

    function witchTime(hour) {
        let h = Number(hour.split(":")[0])
        let m = Number(hour.split(":")[2])
        if (h < 12) return "صبح"
        if (h > 12 && h < 16) return "ظهر"
        if (h > 16 && h < 19) return "عصر"
        if (h > 12) return "شب"
    }
</script>


