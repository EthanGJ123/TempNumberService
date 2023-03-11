<?php
namespace TempNumberService\Models;

require_once($_SERVER['DOCUMENT_ROOT'] . "/Models/MessageData.php");
class MessageDataSet
{
    public static string $tablename = "Messages";

    public static function fetch_all(string $recipient = null) : array|false
    {
        $dbRows = MessageDataSet::fetch_all_records($recipient);
        if(!$dbRows)
            return false;
        $dataSet = [];
        foreach ($dbRows as $dbRow)
        {
            $dataSet[] = new MessageData($dbRow);
        }
        return $dataSet;
    }

    private static function fetch_all_records(string $recipient = null) : array|false
    {
        $sqlStatement = "SELECT * FROM " . MessageDataSet::$tablename . " WHERE recipient=?";
        $result = Database::execute_statement($sqlStatement, array($recipient));
        return $result->fetchAll();
    }

    public static function fetch_inbox_count_for(string $recipient) : int
    {
        $sqlStatement = "SELECT COUNT(*) FROM " . MessageDataSet::$tablename . " WHERE recipient=?";
        $result = Database::execute_statement($sqlStatement, array($recipient));
        return $result->fetchColumn(0);
    }
}