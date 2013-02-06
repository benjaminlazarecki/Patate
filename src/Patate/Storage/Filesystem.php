<?php

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
        foreach ($contents as $content) {
            $this->identifiers[] = $this->write($content);
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

        file_put_contents('/tmp/' . $identifier, $content);

        return $identifier;
    }

    /**
     * Destroy the given file.
     *
     * @param string $identifier
     */
    public function clear($identifier)
    {
        unlink('/tmp/' . $identifier);
    }
}
