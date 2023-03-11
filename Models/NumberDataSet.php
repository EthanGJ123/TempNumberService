<?php
namespace TempNumberService\Models;
require_once($_SERVER['DOCUMENT_ROOT'] . "/Models/Database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Models/NumberData.php");

class NumberDataSet
{
    public static string $tablename = "Numbers";

    public static function fetch(string $number) : NumberData|false
    {
        $dbRow = NumberDataSet::fetch_record($number);
        if(!$dbRow)
            return false;
        return new NumberData($dbRow);
    }

    private static function fetch_record(string $number) : array|false
    {
        $sqlStatement = "SELECT * FROM " . NumberDataSet::$tablename . " WHERE number=?";
        $result = Database::execute_statement($sqlStatement, array($number));
        return $result->fetch();
    }

    public static function fetch_all(bool $includeKeywords = false, string $keywords = null) : array|false
    {
        $dbRows = NumberDataSet::fetch_all_records($includeKeywords, $keywords);
        if(!$dbRows)
            return false;
        $dataSet = [];
        foreach ($dbRows as $dbRow)
        {
            $dataSet[] = new NumberData($dbRow);
        }
        return $dataSet;
    }

    private static function fetch_all_records(bool $includeKeywords = false, string $keywords = null) : array|false
    {
        $params = [];
        $sqlStatement =
            "SELECT number, GROUP_CONCAT(text SEPARATOR '|') AS concat_text, COUNT(text)" .
            " FROM " . NumberDataSet::$tablename .
            ($includeKeywords ? "" : " LEFT") . " JOIN (" .
            " SELECT recipient, text" .
            " FROM " . MessageDataSet::$tablename;
        if($keywords != null)
        {
            $keywords = explode(" ", $keywords);
            for ($i = 0; $i < count($keywords); $i++) {
                $sqlStatement .=
                    ($i == 0 ? " WHERE " : " OR ") .
                    "text" .
                    ($includeKeywords ? "" : " NOT") .
                    " LIKE ?";
                $params[] = "%" . $keywords[$i] . "%";
            }
        }
        $sqlStatement .=
            " )" .
            " AS JoinTable" .
            " ON number = recipient" .
            " GROUP BY number;";

        var_dump($sqlStatement);

        $result = Database::execute_statement($sqlStatement, $params);
        return $result->fetchAll();
    }
}