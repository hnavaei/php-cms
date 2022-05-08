<?php

class Group extends Db
{
    protected $data = array(
        "group_id" => 0,
        "group_name" => ""
    );

    public static function getGroups()
    {
        $conn = Db::connect();
        $query = "SELECT * FROM `tbl_group` ORDER BY `group_id`";
        $result = $conn->prepare($query);
        $result->execute();
        $groups = array();
        if ($result->rowCount() > 0) {
            foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($groups, new Group($row));
            }
            return $groups;
        }
        return false;
    }

    public static function getGroupById($id)
    {
        $conn = Db::connect();
        $query = "SELECT * FROM `tbl_group` WHERE `group_id`='$id'";
        $result = $conn->query($query);

        if ($result->rowCount() > 0) {
            return new Group($result->fetch(PDO::FETCH_ASSOC));
        }
        return false;
    }

}