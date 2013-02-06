<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Patate\Model;

use Patate\Storage\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Execute the phpcs on files.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class PhpCodeSniffer
{
    /** @var \Patate\Storage\Filesystem */
    protected $filesystem;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem The filesystem.
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Execute phpcs on given files.
     *
     * @param array $contents
     *
     * @return array
     */
    public function run(array $contents)
    {
        $this->filesystem->writeAll($contents);
        $identifiers = $this->filesystem->getIdentifiers();

        $results = array();
        foreach ($identifiers as $filename => $identifier) {
            $process = new Process(sprintf("phpcs %s", $identifier), sys_get_temp_dir());
            $process->run();
            $results[$filename] = explode("\n", $process->getOutput());
        }

        $this->filesystem->clearAll();

        return $results;
    }
}
