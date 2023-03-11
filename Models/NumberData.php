<?php
namespace TempNumberService\Models;
use DateTime;

class NumberData
{
    private string $number;

    public function __construct($dbRow)
    {
        if(!$dbRow)
            return;
        $this->number = $dbRow['number'];
    }

    public function get_number() : string
    {
        return $this->number;
    }
}