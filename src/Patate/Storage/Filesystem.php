<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Patate\Storage;

/**
 * Represent the filesystem where files are store.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class Filesystem
{
    /**
     * @var array
     */
    protected $identifiers;

    /**
     * Return the file identifiers.
     *
     * @return array
     */
    public function getIdentifiers()
    {
        return $this->identifiers;
    }

    /**
     * Write all given content.
     *
     * @param array $contents
     */
    public function writeAll($contents)
    {
        foreach ($contents as $filename => $content) {
            $this->identifiers[$filename] = $this->write($content);
        }
    }

    /**
     * Clear all created files.
     */
    public function clearAll()
    {
        foreach ($this->identifiers as $identifier) {
            $this->clear($identifier);
        }
    }

    /**
     * Write a content on disk and return an unique name for retrieve file.
     *
     * @param string $content
     *
     * @return string
     */
    public function write($content)
    {
        $identifier = uniqid('patate_');

        file_put_contents(sprintf('%s/%s', sys_get_temp_dir(), $identifier), $content);

        return $identifier;
    }

    /**
     * Destroy the given file.
     *
     * @param string $identifier
     */
    public function clear($identifier)
    {
        unlink(sprintf('%s/%s',sys_get_temp_dir(), $identifier));
    }
}
