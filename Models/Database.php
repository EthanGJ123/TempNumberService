<?php
namespace TempNumberService\Models;
use Exception;
use PDO;
use PDOStatement;

class Database
{
    protected static $_dbHandle = null;

    /***
     * Connects to the poseidon hosted database
     * Sets the field $_dbHandle
     * @return void
     */
    private static function new_connection() : void
    {
        $username = "age986";
        $password = "mrc3jvgbFzSx";
        $host = "poseidon.salford.ac.uk";
        $database = "age986_tempphonenumberservice";
        try {
            self::$_dbHandle = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        }
        catch (Exception $ex) {
            echo $ex -> getMessage();
        }

    }

    /**
     * Gets the singleton implementation of the database PDO object
     * Connects to the poseidon hosted database if no connection exists
     * @return PDO The connection to the database
     */
    private static function get_connection() : PDO
    {
        //Singleton implementation of Database PDO object
        if (self::$_dbHandle == null) {
            self::new_connection(); //create new object
        }
        return self::$_dbHandle;
    }

    /**
     * Executes a statement on the database
     * @param string $sqlStatement The statement to be executed, with placeholders if needed
     * @param array $params The values to be bound to the statement's placeholders
     * @return PDOStatement|false The statement after preparation and execution, false if an error occurs
     */
    public static function execute_statement(string $sqlStatement, array $params = []) : PDOStatement|false
    {
        $statement = Database::get_connection()->prepare($sqlStatement);
        if(!$statement)
            return false;

        for($i = 0; $i < count($params); $i++)
        {
            $params[$i] = htmlspecialchars($params[$i]);
            $statement->bindParam($i + 1, $params[$i]);
        }
        $result = $statement->execute();
        return $result ? $statement : false;
    }
}