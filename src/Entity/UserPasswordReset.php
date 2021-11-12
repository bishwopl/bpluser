<?php

namespace BplUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use BplUser\Provider\UserPasswordResetInterface;

/**
 * UserPasswordReset
 *
 * @ORM\Table(name="user_password_reset", uniqueConstraints={@ORM\UniqueConstraint(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class UserPasswordReset implements UserPasswordResetInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="request_key", type="string", length=32, nullable=false)
     * @ORM\Id
     * 
     */
    private $requestKey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="request_time", type="datetime", nullable=false)
     */
    private $requestTime;

    /**
     * @var \BplUser\Provider\BplUserInterface
     *
     * @ORM\ManyToOne(targetEntity="\BplUser\Provider\BplUserInterface")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * Set requestKey
     *
     * @param string $requestKey
     *
     * @return UserPasswordReset
     */
    public function setRequestKey($requestKey) {
        $this->requestKey = $requestKey;
        return $this;
    }

    /**
     * Get requestKey
     *
     * @return string
     */
    public function getRequestKey()
    {
        return $this->requestKey;
    }

    /**
     * Set requestTime
     *
     * @param \DateTime $requestTime
     *
     * @return UserPasswordReset
     */
    public function setRequestTime(\DateTime $requestTime)
    {
        $this->requestTime = $requestTime;

        return $this;
    }

    /**
     * Get requestTime
     *
     * @return \DateTime
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * Set user
     *
     * @param $user
     *
     * @return UserPasswordReset
     */
    public function setUser($user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BplUser\Provider\BplUserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}
