<div id="navbar-custom">
    <div class="user-info d-flex align-items-center justify-content-between">
        <div class="user-img">
            <img src="images/<?php echo ($_SESSION["user"]["user_type"] == "ادمین" ? "admin-logo.png" : $_SESSION["user"]["user_type"] == "پزشک") ? "doctor-logo.png" : "patient-logo.png" ?>">
        </div>
        <p class="d-flex flex-column justify-content-start align-items-end">
            <span class="text-yellow font-weight-bold"><?php echo $_SESSION["user"]["user_username"] ?></span>
            <span class="text-light font-weight-bold"><?php echo $_SESSION["user"]["user_type"] ?></span>
        </p>
    </div>

    <?php if ($_SESSION["user"]["user_type"] == "مراجعه کننده"): ?>
        <div class="mt-3" id="list-tab">
            <a class="list-group-item" href="profile.php"><img src="images/ic_account_box_white_24dp.png" class="ml-1">پروفایل</a>
            <a class="list-group-item" href="doctors.php"><img src="images/ic_assignment_ind_white_24dp.png" class="ml-1">لیست پزشکان</a>
            <a class="list-group-item" href="appointment_reserved.php"><img src="images/ic_assignment_ind_white_24dp.png" class="ml-1">نوبت های رزرو شده</a>
        </div>
    <?php elseif ($_SESSION["user"]["user_type"] == "ادمین") : ?>
        <div class="mt-3" id="list-tab">
            <a class="list-group-item" href="index.php"><img src="images/ic_account_balance_wallet_white_24dp.png" class="ml-1">داشبورد</a>
            <a class="list-group-item" href="profile.php"><img src="images/ic_account_box_white_24dp.png" class="ml-1">پروفایل</a>
            <a class="list-group-item" href="patients.php"><img src="images/ic_assignment_ind_white_24dp.png" class="ml-1">لیست بیماران</a>
            <a class="list-group-item" href="doctors.php"><img src="images/ic_assignment_ind_white_24dp.png" class="ml-1">لیست پزشکان</a>
            <a class="list-group-item" href="add_doctor.php"><img src="images/ic_group_add_white.png" class="ml-1">اضافه کردن پزشک</a>
            <a class="list-group-item" href="add_patient.php"><img src="images/ic_group_add_white.png" class="ml-1">اضافه کردن بیمار</a>
            <a class="list-group-item" href="appointment.php"><img src="images/ic_alarm_white_24dp.png" class="ml-1">نوبت بیماران</a>
        </div>
    <?php else: ?>
        <div class="mt-3" id="list-tab">
            <a class="list-group-item" href="profile.php"><img src="images/ic_account_box_white_24dp.png" class="ml-1">پروفایل</a>
            <a class="list-group-item" href="patients.php"><img src="images/ic_assignment_ind_white_24dp.png" class="ml-1">لیست بیماران</a>
            <a class="list-group-item" href="add_patient.php"><img src="images/ic_group_add_white.png" class="ml-1">اضافه کردن بیمار</a>
            <a class="list-group-item" href="appointment.php"><img src="images/ic_alarm_white_24dp.png" class="ml-1">نوبت بیماران</a>
        </div>
    <?php endif; ?>
</div>

