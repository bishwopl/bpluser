<?php

namespace BplUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BplUser\Entity\User
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 *
 */
class User implements \BplUser\Provider\BplUserInterface {
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", unique=true,  length=255)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(name="firstName", nullable=true, type="string", length=64)
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(name="lastName", nullable=true, type="string", length=64)
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(name="address", nullable=true, type="string", length=128)
     */
    protected $address;

    /**
     * @var string
     * @ORM\Column(name="city", nullable=true, type="string", length=64)
     */
    protected $city;

    /**
     * @var string
     * @ORM\Column(name="country", nullable=true, type="string", length=2)
     */
    protected $country;

    /**
     * @var string
     * @ORM\Column(name="zip", nullable=true, type="string", length=10)
     */
    protected $zip;

    /**
     * @var string
     * @ORM\Column(name="phone", nullable=true, type="string", length=32)
     */
    protected $phone;

    /**
     * @var string
     * @ORM\Column(name="state", nullable=true, type="string", length=32)
     */
    protected $state;

    /**
     * @ORM\Column(name="timeRegistered", type="datetime")
     */
    protected $timeRegistered;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="CirclicalUser\Entity\Role")
     * @ORM\JoinTable(name="users_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;

    /**
     * Initialies the roles variable.
     */
    public function __construct() {
        if ($this->timeRegistered == NULL) {
            $this->timeRegistered = new \DateTime();
        }
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles() {
        return $this->roles->getValues();
    }

    /**
     * Add a role to the user.
     *
     * @param \CirclicalUser\Provider\RoleInterface $role
     *
     * @return void
     */
    public function addRole(\CirclicalUser\Provider\RoleInterface $role) {
        $this->roles[] = $role;
    }

    /**
     * @return mixed
     */
    public function getTimeRegistered() {
        return $this->timeRegistered;
    }

    /**
     * @param mixed $timeRegistered
     */
    public function setTimeRegistered($timeRegistered) {
        $this->timeRegistered = $timeRegistered;
    }

    /**
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address) {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city) {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getZip() {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip) {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone) {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getState() {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state) {
        $this->state = $state;
    }

    public function removeRole(\CirclicalUser\Provider\RoleInterface $role) {
        $this->roles->removeElement($role);
    }

    public function hasRole(\CirclicalUser\Provider\RoleInterface $role) {
        $this->roles->contains($role);
    }

}
