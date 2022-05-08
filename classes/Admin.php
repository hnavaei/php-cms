<?php
class Admin extends Db
{
    protected $data = array(
        "admin_id" => 0,
        "admin_username" => "",
        "admin_email" => "",
        "admin_password" => "",
        "admin_gender" => "",
    );

    public static function login($pass, $email)
    {
        $conn = Db::connect();
        $query = "SELECT * FROM `tbl_admin` WHERE `admin_password`=? AND `admin_email`=?";
        $result = $conn->prepare($query);
        $result->bindValue(1, $pass);
        $result->bindValue(2, $email);
        $result->execute();
        $admin = [];
        if ($result->rowCount() > 0) {
            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($admin, new Admin($row));
            }
            return $admin;
        } else return false;
    }

    public static function changePwd($old_pwd, $new_pwd, $email)
    {
        $conn = Db::connect();
        $query = "SELECT * FROM `tbl_admin` WHERE `admin_password`=$old_pwd";
        $result = $conn->query($query);
        if ($result->rowCount() > 0) {
            $query = "UPDATE `tbl_admin` SET `admin_password`=? WHERE `admin_password`=? AND `admin_email`=?";
            $result = $conn->prepare($query);
            $result->bindValue(1, $new_pwd);
            $result->bindValue(2, $old_pwd);
            $result->bindValue(3, $email);
            return $result->execute();
        }
        return false;
    }

}