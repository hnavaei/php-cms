<?php
class Db
{
    static $host = "localhost";
    static $dbname = "hospital";
    static $password = "";
    static $username = "root";
    protected $data = array();

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->data)) {
                if (is_numeric($value)) $this->data[$key] = (int)$value;
                else $this->data[$key] = $value;
            }
        }
    }

    public static function connect()
    {
        try {
            $conn = new PDO("mysql::host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8", self::$username, self::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            die("connection failed" . $error->getMessage());
        }
        return $conn;
    }

    public function __get($prop)
    {
        if (array_key_exists($prop, $this->data)) return $this->data[$prop];
        die("Invalid Data");
    }

    public static function changePageToLogin()
    {
        if (!isset($_SESSION["user"]) and empty($_SESSION["user"])) header("location:login.php");
    }

}
