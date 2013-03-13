<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Patate\Report;

/**
 * Represent a patate report.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class Report
{
    /**
     * @const string Constant use for text report.
     */
    const FORMAT_TEXT = 'text';

    /**
     * @var array The non formatted report.
     */
    protected $report;

    /**
     * Gets the non formatted report.
     *
     * @return array
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Sets the non formatted report.
     *
     * @param array $report
     *
     * @return Report
     */
    public function setReport($report)
    {
        $this->report = $report;
    }

    /**
     * Return the report in the given format.
     *
     * @param string $format
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function format($format)
    {
        switch ($format) {
            case static::FORMAT_TEXT:
                return $this->formatText();
                break;
        }

        throw new \InvalidArgumentException(sprintf('Format : %s does not exist', $format));
    }

    /**
     * Return the text format.
     *
     * @return string
     */
    protected function formatText()
    {
        $contents = '';

        foreach ($this->report as $filename => $report) {
            if (count($report) > 3) {
                // Replace the identifier by the filename.
                $report[1] = sprintf('FILE: %s', $filename);

                $contents .= implode(PHP_EOL, $report);
            }
        }

        return $contents;
    }

    /**
     * Return the markdown format.
     *
     * @throws \Exception
     */
    protected function formatMarkdown()
    {
        throw new \Exception('not yet implemented');
    }
}
