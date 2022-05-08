<?php

class Work_time extends Db
{
    protected $data = array(
        "id" => 0,
        "doctor_id" => 0,
        "day" => "",
        "from_hour" => "",
        "to_hour" => ""
    );

    public static function getWorkTimeDoctor($dr_id)
    {
        $conn = Db::connect();
        $query = "SELECT * FROM `tbl_working_time_doctor` WHERE `doctor_id`=$dr_id";
        $result = $conn->query($query);
        $day = array();
        if ($result->rowCount() > 0) {
            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($day, new Work_time($row));
            }
            return $day;
        }
        return false;
    }

    public static function addWorkTimeDoctor($dr_id, $day, $from, $to)
    {
        $conn = Db::connect();
        $query = "INSERT INTO `tbl_working_time_doctor` SET `doctor_id`=? , `day`=? , `from_hour`=? , `to_hour`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $dr_id);
        $result->bindValue(2, $day);
        $result->bindValue(3, $from);
        $result->bindValue(4, $to);
        $result->execute();
    }

    public static function editWorkTimeDoctor($day, $from, $to, $work_time_id)
    {
        $conn = Db::connect();
        $query = "UPDATE `tbl_working_time_doctor` SET `day`=? , `from_hour`=? , `to_hour`=? WHERE `id`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $day);
        $result->bindValue(2, $from);
        $result->bindValue(3, $to);
        $result->bindValue(4, $work_time_id);
        $result->execute();
    }

}