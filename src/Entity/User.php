<?php

namespace BplUser\Entity;

use CirclicalUser\Entity\UserApiToken;
use CirclicalUser\Provider\AuthenticationRecordInterface;
use CirclicalUser\Provider\RoleInterface;
use CirclicalUser\Provider\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonException;
use BplUser\Provider\BplUserInterface;
use BplUser\Entity\UserPasswordReset;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 *
 */
class User implements \BplUser\Contract\BplUserInterface {

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     */
    public const EVENT_REGISTERED = 'user.registered';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", nullable=false, options={"unsigned"=true})
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=255)
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"});
     *
     * @var \DateTimeImmutable
     */
    private $timeRegistered;
    
    /**
     * @var string
     * @ORM\Column(name="state", nullable=true, type="string", length=32)
     */
    protected $state;

    /**
     * @ORM\ManyToMany(targetEntity="CirclicalUser\Entity\Role", cascade={"persist"})
     * @ORM\JoinTable(
     *     name="users_roles",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $roles;

    /**
     * @ORM\OneToOne(targetEntity="CirclicalUser\Entity\Authentication", cascade={"persist"}, mappedBy="user")
     */
    private $authenticationRecord;

    /**
     * @ORM\OneToMany(targetEntity="CirclicalUser\Entity\UserApiToken", mappedBy="user", cascade={"all"});
     *
     * @var Collection | Array<UserApiToken>
     * 
     */ 
    private $apiTokens;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $avatar;
    
    /**
     * @ORM\OneToOne(targetEntity="BplUser\Entity\UserPasswordReset", mappedBy="user", orphanRemoval=true)
     */
    private ?UserPasswordReset $userPasswordReset;

    public function __construct()
    {
        $this->timeRegistered = new \DateTimeImmutable();
        $this->roles = new ArrayCollection();
        $this->apiTokens = new ArrayCollection();
        $this->userPasswordReset = null;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function setState(string $state): void {
        $this->state = $state;
    }

    public function setRoles($roles): void {
        $this->roles = $roles;
    }

    public function setApi_tokens(Collection $apiTokens): void {
        $this->apiTokens = $apiTokens;
    }

        
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles->getValues();
    }
    
    public function addRoles($roles): void
    {
        foreach($roles as $role){
            $this->addRole($role);
        }
    }

    public function addRole(RoleInterface $role): void
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }
    }

    public function removeRoles($roles): void
    {
        foreach($roles as $role){
            $this->removeRole($role);
        }
    }
    
    public function removeRole(RoleInterface $role): void
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }
    }

    public function getTimeRegistered(): \DateTimeImmutable
    {
        return $this->timeRegistered;
    }

    public function getPreferredTimezone(): \DateTimeZone
    {
        return new \DateTimeZone('America/New_York');
    }

    public function hasRoleWithName(string $roleName): bool
    {
        foreach ($this->roles as $role) {
            if ($role->getName() === $roleName) {
                return true;
            }
        }

        return false;
    }

    public function hasRole(RoleInterface $searchRole): bool
    {
        return $this->roles->contains($searchRole);
    }

    public function setAuthenticationRecord(?AuthenticationRecordInterface $authentication): void
    {
        $this->authenticationRecord = $authentication;
    }

    public function getAuthenticationRecord(): ?AuthenticationRecordInterface
    {
        return $this->authenticationRecord;
    }

    public function getApiTokens(): ?Collection
    {
        return $this->apiTokens;
    }

    public function addApiToken(UserApiToken $token): void
    {
        $this->apiTokens->add($token);
    }

    public function getApiTokenArray(): array
    {
        return $this->apiTokens->map(static function (UserApiToken $token) {
            return $token->getToken();
        })->getValues();
    }

    /**
     * @throws JsonException
     */
    public function getApiTokensAsJson(): string
    {
        return json_encode($this->getApiTokenArray(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    public function findApiTokenWithId(string $uuid): ?UserApiToken
    {
        foreach ($this->apiTokens as $token) {
            if ($token->getToken() === $uuid) {
                return $token;
            }
        }

        return null;
    }

    public function removeApiToken(UserApiToken $token): void
    {
        if ($this->apiTokens->contains($token)) {
            $this->apiTokens->removeElement($token);
        }
    }

    public function getState() {
        return $this->state;
    }
    
    public function getAvatar(): ?string {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): void {
        $this->avatar = $avatar;
    }
    
    public function getUserPasswordReset(): ?UserPasswordReset {
        return $this->userPasswordReset;
    }

    public function setUserPasswordReset(?UserPasswordReset $userPasswordReset) {
        $this->userPasswordReset = $userPasswordReset;
        return $this;
    }

}
