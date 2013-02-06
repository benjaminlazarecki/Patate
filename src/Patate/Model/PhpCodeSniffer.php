<?php

namespace Patate\Model;

/**
 * Execute the phpcs on files.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class PhpCodeSniffer
{
    /**
     * Execute phpcs on given files.
     *
     * @param array $files
     *
     * @return array
     */
    public function execute(array $files)
    {
        $results = array();
        $phpcsReport = array();
        foreach ($files as $file) {
            exec("phpcs /tmp/" . $file, $phpcsReport);
            array_shift($phpcsReport);
            $results[] = $phpcsReport;
        }

        return $results;
    }
}
