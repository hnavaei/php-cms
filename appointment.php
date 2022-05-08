<?php
include_once "inc/header.php";
Db::changePageToLogin();
?>
<!--Appointment Form-->
<div class="container-fluid">
    <div class="row m-0 align-items-center">
        <div class="col-xl-2"><?php include_once "inc/sidebar.php"; ?></div>
        <div class="col-xl-10">
            <div id="appointment">
                <div class="content-body">
                    <table class="table" id="appointment-table">
                        <thead>
                        <tr>
                            <th>ریف</th>
                            <th>نام بیمار</th>
                            <th>پزشک</th>
                            <th>عنوان تخصص</th>
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
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $row->patient ?></td>
                                    <td>
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
                                    <td><?php echo $row->doctor_group ?></td>
                                    <td><?php echo $row->in_date ?></td>
                                    <td><?php echo $row->in_hour ?></td>
                                    <td><?php echo $row->code ?></td>
                                    <td><?php echo !Appointment::isAppointmentDone($row->in_date) ? "<span class='badge badge-secondary'>در نوبت</span>" : "<span class='badge badge-success'>ویزیت شده</span>" ?></td>
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
    $("#appointment-table").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/fa.json"
        }
    })
</script>

