<?php

namespace TempNumberService;

class UserInput
{
    /**
     * Sanitizes a string input by stripping away html characters.
     * @param string $input The string to be sanitized.
     * @return string The sanitized string.
     */
    public static function sanitize(string $input) : string
    {
        return htmlspecialchars($input);
    }

    /**
     * Sanitizes an array of string inputs by stripping away html characters.
     * @param array $inputs An array containing the strings to be sanitized.
     * @return array An array containing the sanitized strings.
     */
    public static function sanitize_many(array $inputs) : array
    {
        for($i = 0; $i < count($inputs); $i++)
        {
            $inputs[$i] = self::sanitize($inputs[$i]);
        }
        return $inputs;
    }
}