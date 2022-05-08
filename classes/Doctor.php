<?php

class Doctor extends Db
{
    protected $data = array(
        "doctor_id" => "",
        "doctor_name" => "",
        "doctor_lastname" => "",
        "doctor_group" => 0,
        "doctor_pic" => "",
        "doctor_gender" => "",
        "doctor_phone" => "",
        "doctor_email" => "",
        "doctor_password" => 0,
        "group_name" => "",

    );

    public static function getDoctorWithId($doctor_id)
    {
        $conn = Db::connect();
        $query = "SELECT * FROM `tbl_doctors` WHERE `doctor_id`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $doctor_id);
        $result->execute();
        if ($result->rowCount() > 0) {
            return new Doctor($result->fetch(PDO::FETCH_ASSOC));
        }
        return false;
    }

    public static function getDoctors()
    {
        $conn = Db::connect();
        $query = "SELECT * , `group_name` FROM `tbl_doctors` , `tbl_group` WHERE tbl_group.group_id = tbl_doctors.doctor_group ";
        $result = $conn->prepare($query);
        $result->execute();
        $doctors = array();
        if ($result->rowCount() > 0) {
            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $doctor_row) {
                array_push($doctors, new Doctor($doctor_row));
            }
            return $doctors;
        }
        return false;
    }

    public static function addDoctor($d_name, $d_lastname, $d_group, $d_gender, $d_email, $d_phone, $d_pass, $d_pic = "000")
    {
        $conn = Db::connect();
        $query = "INSERT INTO `tbl_doctors` SET `doctor_name`=? , `doctor_lastname`=? , `doctor_group`=? , `doctor_gender`=? , `doctor_email`=? , `doctor_phone`=? , `doctor_password`=? , `doctor_pic`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $d_name);
        $result->bindValue(2, $d_lastname);
        $result->bindValue(3, $d_group);
        $result->bindValue(4, $d_gender);
        $result->bindValue(5, $d_email);
        $result->bindValue(6, $d_phone);
        $result->bindValue(7, $d_pass);
        $result->bindValue(8, $d_pic);
        $result->execute();
        return $conn->lastInsertId();
    }

    public static function updateDoctor($d_name, $d_lastname, $d_group, $d_email, $d_phone, $d_id, $d_pic = "000")
    {
        $conn = Db::connect();
        $query = "UPDATE `tbl_doctors` SET `doctor_name`=? , `doctor_lastname`=? , `doctor_group`=? , `doctor_email`=? , `doctor_phone`=? , `doctor_pic`=? WHERE `doctor_id`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $d_name);
        $result->bindValue(2, $d_lastname);
        $result->bindValue(3, $d_group);
        $result->bindValue(4, $d_email);
        $result->bindValue(5, $d_phone);
        $result->bindValue(6, $d_pic);
        $result->bindValue(7, $d_id);
        $result->execute();
    }

    public static function deleteDoctor($id)
    {
        $conn = Db::connect();
        $query = "DELETE FROM `tbl_doctors` WHERE `doctor_id`=$id";
        $conn->query($query);

    }

    public static function loginDoctor($dr_email, $dr_pass)
    {
        $conn = Db::connect();
        $query = "SELECT * FROM `tbl_doctors` WHERE `doctor_email`=? AND `doctor_password`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $dr_email);
        $result->bindValue(2, $dr_pass);
        $result->execute();
        $doctors = array();
        if ($result->rowCount() > 0) {
            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($doctors, new Doctor($row));
            }
            return $doctors;
        } else return false;
    }

}