<?php

namespace App\Services;

/**
 * Service for reading file content.
 *
 * @author Petyo Ruzhin
 */
class FileService
{
    /**
     * @desc Reads configurations made in App\Storage\input.ini file.
     */
    public static function readConfigInput()
    {
        $fileName = ROOT_DIR .'/src/Storage/input.ini';

        // Checks if such file doesn't exist.
        if (!file_exists($fileName)) {
            throw new \Non('Invalid file path!');
        }

        return parse_ini_file($fileName, true);
    }

    /**
     * @desc Reads data from App\Storage\input.csv file.
     */
    public static function readDataInput()
    {
        $fileName = ROOT_DIR .'/src/Storage/input.csv';

        // Checks if such file doesn't exist.
        if (!file_exists($fileName)) {
            throw new \InvalidArgumentException('Invalid file path!');
        }

        /**
         * 1. Reading the file into an array containing each row as a string via file($fileName).
         * 2. Looping through all array elements.
         * 3. Parsing each row content via str_getcsv().
         */
        $data = array_map('str_getcsv', file($fileName));

        return $data;
    }

    /**
     * @desc Outputs to the STDOUT.
     * @param array $data Array of strings.
     */
    public static function printToStdout($data)
    {
        foreach ($data as $k => $v) {
            // Output only if valid!
            if (is_string($v) || is_float($v) || is_int($v)) {
                echo  $v . PHP_EOL;
            }
        }
    }
}
