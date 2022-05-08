<?php

class Patient extends Db
{
    protected $data = array(
        "patient_id" => 0,
        "patient_name" => "",
        "patient_lastname" => "",
        "patient_age" => 0,
        "patient_gender" => "",
        "patient_phone" => "",
        "patient_info" => "",
        "patient_password" => 0,
        "patient_email" => "",
    );

    public static function getAllPatient()
    {
        $conn = Db::connect();
        $query = "SELECT *  FROM `tbl_patients` ORDER BY `patient_info` ";
        $result = $conn->prepare($query);
        $result->execute();
        $patients = array();
        if ($result->rowCount() > 0) {
            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $patient_row) {
                array_push($patients, new Patient($patient_row));
            }
            return $patients;
        } else return false;
    }

    public static function getPatientWithId($patient_id)
    {
        $conn = Db::connect();
        $query = "SELECT *  FROM `tbl_patients` WHERE `patient_id`='$patient_id'";
        $result = $conn->query($query);
        if ($result->rowCount() > 0) {
            return new Patient($result->fetch(PDO::FETCH_ASSOC));
        }
        return false;
    }

    public static function getPatient($email, $num)
    {
        $conn = Db::connect();
        $query = "SELECT *  FROM `tbl_patients` WHERE `patient_email`=? AND `patient_password`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $email);
        $result->bindValue(2, $num);
        $result->execute();
        $patients = array();
        if ($result->rowCount() > 0) {
            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $patient_row) {
                array_push($patients, new Patient($patient_row));
            }
            return $patients;
        } else return false;
    }

    public static function addPatient($p_name, $p_lastname, $p_age, $p_gender, $p_phone, $p_email, $p_pass, $p_info = " ")
    {
        $conn = Db::connect();
        $query = "INSERT INTO `tbl_patients` SET `patient_name`=? , `patient_lastname`=? , `patient_age`=? , `patient_gender`=? , `patient_phone`=? , `patient_password`=? , `patient_email`=? , `patient_info`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $p_name);
        $result->bindValue(2, $p_lastname);
        $result->bindValue(3, $p_age);
        $result->bindValue(4, $p_gender);
        $result->bindValue(5, $p_phone);
        $result->bindValue(6, $p_pass);
        $result->bindValue(7, $p_email);
        $result->bindValue(8, $p_info);
        $result->execute();
    }

    public static function editPatient($p_id, $p_name, $p_lastname, $p_age, $p_phone, $p_email, $p_pass, $p_info = " ")
    {
        $conn = Db::connect();
        $query = "UPDATE `tbl_patients` SET `patient_name`=? , `patient_lastname`=? , `patient_age`=? , `patient_phone`=? , `patient_password`=? , `patient_email`=? , `patient_info`=? WHERE `patient_id`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $p_name);
        $result->bindValue(2, $p_lastname);
        $result->bindValue(3, $p_age);
        $result->bindValue(4, $p_phone);
        $result->bindValue(5, $p_pass);
        $result->bindValue(6, $p_email);
        $result->bindValue(7, $p_info);
        $result->bindValue(8, $p_id);
        $result->execute();
    }

    public static function deletePatient($p_id)
    {
        $conn = Db::connect();
        $query = "DELETE FROM `tbl_patients` WHERE `patient_id`=$p_id";
        $conn->query($query);
    }

}