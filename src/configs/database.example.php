<?php
// configs/database.example.php
class Database
{
    private static ?mysqli $conn = null;

    public static function getConnection(): mysqli
    {
        if (self::$conn === null) {
            $host = 'localhost';
            $user = 'SEU_USUARIO_AQUI';
            $pass = 'SUA_SENHA_AQUI';
            $db   = 'preservas_db';
            $port = 3306;

            self::$conn = new mysqli($host, $user, $pass, $db, $port);

            if (self::$conn->connect_error) {
                die('Erro na conexão: ' . self::$conn->connect_error);
            }

            self::$conn->set_charset('utf8mb4');
        }
        return self::$conn;
    }
}
