<?php
class Appointment extends Db
{
    protected $data = array(
        "id" => 0,
        "patient_id" => 0,
        "doctor_id" => 0,
        "in_date" => "",
        "in_hour" => "",
        "code" => "",
        "doctor" => "",
        "patient" => "",
        "doctor_group" => "",
        "doctor_gender" => "",
    );

    public static function getAllApp()
    {
        $conn = Db::connect();
        $query = "SELECT * , `doctor_name` , `doctor_lastname` , `doctor_group` , `patient_name` , `patient_lastname`  FROM `tbl_appointment` , `tbl_doctors` , `tbl_patients` WHERE tbl_appointment.patient_id = tbl_patients.patient_id AND tbl_appointment.doctor_id = tbl_doctors.doctor_id  ";
        $result = $conn->query($query);
        if ($result->rowCount() > 0) {
            $app = array();
            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $row["doctor"] = $row["doctor_name"] . " " . $row["doctor_lastname"];
                $row["patient"] = $row["patient_name"] . " " . $row["patient_lastname"];
                $row["doctor_group"] = Group::getGroupById($row["doctor_group"])->group_name;
                array_push($app, new Appointment($row));
            }
            return $app;
        }
        return false;
    }

    public static function sendApp($patientId, $drId, $date, $hour, $code)
    {
        $conn = Db::connect();
        $query = "INSERT INTO `tbl_appointment` SET `patient_id`=? , `doctor_id`=? , `in_date`=? , `in_hour`=? , `code`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $patientId);
        $result->bindValue(2, $drId);
        $result->bindValue(3, $date);
        $result->bindValue(4, $hour);
        $result->bindValue(5, $code);
        $result->execute();
    }

    public static function getAppWithDrId($dr_id)
    {
        $conn = Db::connect();
        $query = "SELECT *  FROM `tbl_appointment` WHERE `doctor_id`='$dr_id'";
        $result = $conn->query($query);
        $app = array();
        if ($result->rowCount() > 0) {

            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $row["patient"] = Patient::getPatientWithId($row["patient_id"])->patient_name . " " . Patient::getPatientWithId($row["patient_id"])->patient_lastname;
                $row["doctor"] = Doctor::getDoctorWithId($row["doctor_id"])->doctor_name . " " . Doctor::getDoctorWithId($row["doctor_id"])->doctor_lastname;
                $row["doctor_gender"] = Doctor::getDoctorWithId($row["doctor_id"])->doctor_gender;
                $row["doctor_group"] = Group::getGroupById(Doctor::getDoctorWithId($row["doctor_id"])->doctor_group)->group_name;
                array_push($app, new Appointment($row));
            }
            return $app;
        }
        return false;
    }

    public static function isAppointmentDone($date)
    {
        $currentDate = jdate("Y-m-d");
        if ($currentDate > $date) return true;
        return false;
    }

    public static function isAppointmentFull($dr_id, $date, $hour)
    {
        $conn = Db::connect();
        $query = "SELECT * FROM `tbl_appointment` WHERE `doctor_id`=? AND `in_date`=? AND `in_hour`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $dr_id);
        $result->bindValue(2, $date);
        $result->bindValue(3, $hour);
        $result->execute();
        if ($result->rowCount() > 0)
            return true;
        return false;
    }


}