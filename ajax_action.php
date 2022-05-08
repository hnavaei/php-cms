<?php
include_once "include.php";
$hasError = false;
$msg = "";
$output = array();
$res = "";

if (isset($_POST["page"])) {
    if ($_POST["page"] == "login") {
        if ($_POST["action"] == "login") {
            if ($_POST["role"] == 1) {
                $admin = Admin::login(sanitize($_POST["password-login"]), sanitize($_POST["email-login"]));
                if ($admin) {
                    foreach ($admin as $admin_row) {
                        $_SESSION["user"] = array(
                            "user_type" => "ادمین",
                            "user_id" => $admin_row->admin_id,
                            "user_username" => $admin_row->admin_username,
                            "user_email" => $admin_row->admin_email,
                            "user_gender" => $admin_row->admin_gender
                        );
                    }
                } else {
                    $hasError = true;
                    $msg = "کاربری یافت نشد";
                }
            } else {
                $doctor = Doctor::loginDoctor(sanitize($_POST["email-login"]), sanitize($_POST["password-login"]));
                if ($doctor) {
                    foreach ($doctor as $row) {
                        $_SESSION["user"] = array(
                            "user_type" => "پزشک",
                            "user_id" => $row->doctor_id,
                            "user_username" => $row->doctor_name . " " . $row->doctor_lastname,
                            "user_email" => $row->doctor_email,
                            "user_gender" => $row->doctor_gender
                        );
                    }
                } else {
                    $hasError = true;
                    $msg = "کاربری یافت نشد";
                }
            }
        }

        if ($_POST["action"] == "patient_login") {
            $patient = Patient::getPatient(sanitize($_POST["patient-email"]), sanitize($_POST["patient-num"]));
            if ($patient) {
                foreach ($patient as $row) {
                    $_SESSION["user"] = array(
                        "user_type" => "مراجعه کننده",
                        "user_id" => $row->patient_id,
                        "user_username" => $row->patient_name . " " . $row->patient_lastname,
                        "user_email" => $row->patient_email,
                        "user_gender" => $row->patient_gender
                    );
                }
            } else {
                $hasError = true;
                $msg = "کاربری یافت نشد";
            }
        }
    }

    if ($_POST["page"] == "doctor") {
        if ($_POST["action"] == "add_doctor") {
            if (isset($_FILES["doctor-pic"]) and !empty($_FILES["doctor-pic"])) {
                $extension = array("jpeg", "jpg", "png");
                $arr_img = explode(".", $_FILES["doctor-pic"]["name"]);
                $extension_img = end($arr_img);
                $pic_name = md5(rand(1, 1000)) . $_FILES["doctor-pic"]["name"];
                $pass = rand(1000, 9999);
                if (in_array($extension_img, $extension)) {
                    move_uploaded_file($_FILES["doctor-pic"]["tmp_name"], __DIR__ . "/upload/" . $pic_name);
                    $last_insert_doctor_id = Doctor::addDoctor(sanitize($_POST["doctor-firstname"]), sanitize($_POST["doctor-lastname"]), $_POST["doctor-group"], sanitize($_POST["doctor-gender"]), sanitize($_POST["doctor-email"]), sanitize($_POST["doctor-phone"]), $pass, $pic_name);
                    for ($i = 1; $i < 8; $i++) {
                        if (isset($_POST["work-day-doctor$i"])) {
                            Work_time::addWorkTimeDoctor($last_insert_doctor_id, $_POST["work-day-doctor$i"], $_POST["work-time-doctor-from$i"], $_POST["work-time-doctor-to$i"]);
                        }
                    }
                    $isEmailSend = isSendEmail($_POST["doctor-email"], $pass);
                    $msg = "کاربر ثبت شد همچنین ایمیلی حاوی رمز عبور  برای کاربر ارسال شد";
                } else {
                    $hasError = true;
                    $msg = "تصویری با فرمت مناسب وارد کنید";
                }
            }
        }
        if ($_POST["action"] == "edit_doctor") {
            if (isset($_FILES["doctor-pic"]["name"]) and !empty($_FILES["doctor-pic"]["name"])) {
                $extension = array("jpeg", "jpg", "png");
                $arr_img = explode(".", $_FILES["doctor-pic"]["name"]);
                $extension_img = end($arr_img);
                $pic_name = md5(rand(1, 1000)) . $_FILES["doctor-pic"]["name"];
                if (in_array($extension_img, $extension)) {
                    move_uploaded_file($_FILES["doctor-pic"]["tmp_name"], __DIR__ . "/upload/" . $pic_name);
                    Doctor::updateDoctor(sanitize($_POST["doctor-firstname"]), sanitize($_POST["doctor-lastname"]), $_POST["doctor-group"], sanitize($_POST["doctor-email"]), sanitize($_POST["doctor-phone"]), $_POST["doctor-id"], $pic_name);
                    for ($i = 1; $i < 8; $i++) {
                        if (isset($_POST["work-day-doctor$i"])) {
                            Work_time::editWorkTimeDoctor($_POST["work-day-doctor$i"], $_POST["work-time-doctor-from$i"], $_POST["work-time-doctor-to$i"], $_POST["work-time-id$i"]);
                        }
                    }
                    $msg = "کاربر با موفقیت ویرایش شد";
                } else {
                    $hasError = true;
                    $msg = "تصویری با فرمت مناسب وارد کنید";
                }
            } else {
                Doctor::updateDoctor(sanitize($_POST["doctor-firstname"]), sanitize($_POST["doctor-lastname"]), $_POST["doctor-group"], sanitize($_POST["doctor-email"]), sanitize($_POST["doctor-phone"]), $_POST["doctor-id"]);
                for ($i = 1; $i < 8; $i++) {
                    if (isset($_POST["work-day-doctor$i"])) {
                        Work_time::editWorkTimeDoctor($_POST["work-day-doctor$i"], $_POST["work-time-doctor-from$i"], $_POST["work-time-doctor-to$i"], $_POST["work-time-id"]);
                    }
                }
                $msg = "کاربر با موفقیت ویرایش ثبت شد";
            }

            if ($_POST["action"] == "delete_doctor") {
                Doctor::deleteDoctor($_POST["doctor_id"]);
                $msg = "کاربر با موفقیت حذف شد";
            }
        }
        if ($_POST["action"] == "delete_doctor") {
            Doctor::deleteDoctor($_POST["doctor_id"]);
            $msg = "کاربر با موفقیت حذف شد";
        }
    }

    if ($_POST["page"] == "appointment") {
        if ($_POST["action"] == "add_appointment") {
            $code = rand(1000, 10000000);
            $res = $code;
            Appointment::sendApp($_SESSION["user"]["user_id"], $_POST["doctor_id"], $_POST["app_date"], $_POST["app_time"], $code);
            $msg = "ثبت شد";
        }
        if ($_POST["action"] == "doctor_work_time") {
            $working_time = Work_time::getWorkTimeDoctor($_POST["doctor_id"]);
            $res = null;
            if ($working_time) {
                foreach ($working_time as $row) {
                    foreach (calender($row->day) as $key => $value) {
                        $res[] = array(
                            "day" => $row->day,
                            "from" => $row->from_hour,
                            "to" => $row->to_hour,
                            "date_num" => $key,
                            "date" => $value,
                        );

                    }
                }
            }
        }
        if ($_POST["action"] == "doctor_work_time_item") {
            $doctor_id = $_POST["doctor_id"];
            $date = $_POST["date_working"];
            $from_hour = null;
            $to_hour = null;
            if (isset($_POST["working_time_from"]) and !empty($_POST["working_time_from"])) {
                $from_hour = $_POST["working_time_from"];
                $to_hour = date("H:i", strtotime($_POST["working_time_to"]));
            } else {
                foreach (Work_time::getWorkTimeDoctor($_POST["doctor_id"]) as $row) {
                    if ($row->day == $_POST["day_working"]) {
                        $from_hour = $row->from_hour;
                        $to_hour = $row->to_hour;
                    }
                }
            }

            $step = date("H:i", strtotime($from_hour));
            $res = "<div class='row'>";
            while (strtotime($step) < strtotime($to_hour)) {
                if (!Appointment::isAppointmentFull($doctor_id, $date, $step))
                    $res .= "<div class='col-4'><a class='btn my-1 app-item-link'>$step</a></div>";
                else
                    $res .= "<div class='col-4'><a class='btn my-1 app-item-link disabled' >$step</a></div>";
                $step = date("H:i", strtotime($step . " +45 minutes"));
            }
            $res .= "</div>";


        }
    }

    if ($_POST["page"] == "patient") {
        if ($_POST["action"] == "add_patient") {
            $patient_email = sanitize($_POST["patient-email"]);
            $patient_pass = rand(2000, 5000);
            Patient::addPatient(sanitize($_POST["patient-firstname"]), sanitize($_POST["patient-lastname"]), $_POST["patient-age"], sanitize($_POST["patient-gender"]), sanitize($_POST["patient-phone"]), $patient_email, $patient_pass, sanitize($_POST["patient-info"]));

            isSendEmail($patient_email, $patient_pass);
            $msg = "کاربر ثبت شد همچنین ایمیلی حاوی رمز عبور  برای کاربر ارسال شد";
        }
        if ($_POST["action"] == "edit_patient") {
            Patient::editPatient($_POST["patient-id"], sanitize($_POST["patient-firstname"]), sanitize($_POST["patient-lastname"]), $_POST["patient-age"], sanitize($_POST["patient-phone"]), sanitize($_POST["patient-email"]), rand(2000, 5000), sanitize($_POST["patient-info"]));
            $msg = "تغییرات با موفقیت اعمال شد";
        }
        if ($_POST["action"] == "delete_patient") {
            Patient::deletePatient($_POST["patient_id"]);
            $msg = "کاربر با موفقیت حذف شد";
        }
    }

    if ($_POST["page"] == "pwd") {
        if ($_POST["action"] = "change-pwd") {
            if (Admin::changePwd($_POST["old-pass"], $_POST["new-pass"], $_SESSION["user"]["user_email"])) $msg = "تغییرات با موفقیت اعمال شد";
            else {
                $msg = "رمز عبور صحیح نمیباشد";
                $hasError = true;
            }
        }
    }

    $output = array(
        "hasError" => $hasError,
        "msg" => $msg,
        "text" => $res

    );
    echo json_encode($output);
}