<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Models/NumberDataSet.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Models/MessageDataSet.php");

use TempNumberService\Models\MessageDataSet;
use TempNumberService\Models\NumberDataSet;

$view = new stdClass();

if(isset($_GET['number']))
{
    $view->number = $_GET['number'];
    $view->numberdata = NumberDataSet::fetch($view->number);
    $view->numbermessages = MessageDataSet::fetch_all($view->number);
}

$view->includeKeywords =
    isset($_GET['includekeywords'])
    &&
    $_GET['includekeywords'] == "";

$view->keywords = $_GET['keywords'] ?? "";

$view->numbers = NumberDataSet::fetch_all($view->includeKeywords, $view->keywords);

require_once('./Views/index.phtml');