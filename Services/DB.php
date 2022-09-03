<?php


class DB
{
    public $connect;
    private static $instance;

    public function __construct()
    {
        $dbOptions = (require __DIR__ . '/../config/settings.php')['db'];

            $this->connect = mysqli_connect( $dbOptions['host'], $dbOptions['user'], $dbOptions['password'], $dbOptions['dbname']);

    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}




