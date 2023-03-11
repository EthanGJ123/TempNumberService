<?php
namespace TempNumberService\Models;
use DateTime;

class MessageData
{
    private string $sender;
    private string $recipient;
    private string $text;
    private DateTime $timestamp;

    public function __construct($dbRow)
    {
        if(!$dbRow)
            return;
        $this->sender = $dbRow['sender'];
        $this->recipient = $dbRow['recipient'];
        $this->text = $dbRow['text'];
        $this->timestamp = new DateTime();
        $this->timestamp->setTimestamp($dbRow['timestamp']);
    }

    public function get_sender()
    {
        return $this->sender;
    }

    public function get_recipient()
    {
        return $this->recipient;
    }

    public function get_text()
    {
        return $this->text;
    }

    public function get_timestamp()
    {
        return $this->timestamp;
    }
}