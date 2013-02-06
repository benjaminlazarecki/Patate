<?php

namespace Patate\Target;

/**
 * Represent a target. For example a github pull request.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class Target
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $repository;

    /**
     * @var integer
     */
    protected $pullRequestId;

    /**
     * Return the username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username.
     *
     * @param string $username
     *
     * @return \Patate\Target\Target
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Gets the repository.
     *
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Sets the repository.
     *
     * @param string $repository
     *
     * @return \Patate\Target\Target
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Gets the pull request id.
     *
     * @return integer
     */
    public function getPullRequestId()
    {
        return $this->pullRequestId;
    }

    /**
     * Sets the pull request id.
     *
     * @param integer $pullRequestId
     *
     * @return \Patate\Target\Target
     */
    public function setPullRequestId($pullRequestId)
    {
        $this->pullRequestId = (int) $pullRequestId;

        return $this;
    }
}
