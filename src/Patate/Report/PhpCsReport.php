<?php

namespace Patate\Report;

/**
 * Represent a patate report.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class PhpCsReport
{
    /**
     * @const string Constant use for text report.
     */
    const FORMAT_TEXT = 'text';

    /**
     * @var array
     */
    protected $phpCsReports;

    /**
     * Constructor.
     *
     * @param array $phpCsReports
     */
    public function __construct(array $phpCsReports)
    {
        $this->phpCsReports = $phpCsReports;
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

        foreach ($this->phpCsReports as $report) {
            $contents .= implode("\n", $report);
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
