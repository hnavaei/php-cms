<?php
require_once "inc/header.php";
Db::changePageToLogin();
if ($_SESSION["user"]["user_type"] !== "ادمین") header("location:profile.php");
?>
<section>
    <div class="row m-0 align-items-center">
        <div class="col-xl-2">
            <?php include_once "inc/sidebar.php" ?>
        </div>
        <?php if ($_SESSION["user"]["user_type"] == "ادمین"): ?>
        <div class="col-xl-10">
            <div class="row  align-items-center justify-content-around">
                <div class="col-lg-8">
                    <div class="row content-body">
                        <div class="col-xl-6 my-1">
                            <div class="card-custom">
                                <h3 class="text-blue">پزشک</h3>
                                <h3 class="text-red"><?php echo Doctor::getDoctors() ? count(Doctor::getDoctors()) : 0 ?></h3>
                                <a href="doctors.php"> &#8594 جزئیات بیشتر</a>
                            </div>
                        </div>
                        <div class="col-xl-6 my-1">
                            <div class="card-custom">
                                <h3 class="text-blue">بیماران</h3>
                                <h3 class="text-red"><?php echo Patient::getAllPatient() ? count(Patient::getAllPatient()) : 0 ?></h3>
                                <a href="patients.php"> &#8594 جزئیات بیشتر</a>
                            </div>
                        </div>
                        <div class="col-xl-6 my-1">
                            <div class="card-custom">
                                <h3 class="text-blue">نوبت</h3>
                                <h3 class="text-red"><?php echo Appointment::getAllApp() ? count(Appointment::getAllApp()) : 0 ?></h3>
                                <a href="appointment.php"> &#8594 جزئیات بیشتر</a>
                            </div>
                        </div>
                        <div class="col-xl-6 my-1">
                            <div class="card-custom">
                                <h3 class="text-blue">تغییر پسورد</h3>
                                <a href="change_password.php"> &#8594 جزئیات بیشتر</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 d-lg-block d-none">
                    <img src="images/background-two-right.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>
<?php include_once 'inc/footer.php' ?>

<script>
    $("#patient-table,#doctor-table,#appointment-table").DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/fa.json"
        }
    })
</script>


