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
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $last_name;

    /**
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"});
     *
     * @var \DateTimeImmutable
     */
    private $time_registered;
    
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
     * @var Array<RoleInterface>
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
     */
    private $api_tokens;

    public function __construct()
    {
        $this->time_registered = new \DateTimeImmutable();
        $this->roles = new ArrayCollection();
        $this->api_tokens = new ArrayCollection();
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setFirst_name(string $first_name): void {
        $this->first_name = $first_name;
    }

    public function setLast_name(string $last_name): void {
        $this->last_name = $last_name;
    }

    public function setState(string $state): void {
        $this->state = $state;
    }

    public function setRoles($roles): void {
        $this->roles = $roles;
    }

    public function setApi_tokens(Collection $api_tokens): void {
        $this->api_tokens = $api_tokens;
    }

        
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles->getValues();
    }

    public function addRole(RoleInterface $role): void
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }
    }

    public function removeRole(RoleInterface $role): void
    {
        if ($this->roles->contains($role)) {
            $this->roles->remove($role);
        }
    }

    public function getTimeRegistered(): \DateTimeImmutable
    {
        return $this->time_registered;
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
        return $this->api_tokens;
    }

    public function addApiToken(UserApiToken $token): void
    {
        $this->api_tokens->add($token);
    }

    public function getApiTokenArray(): array
    {
        return $this->api_tokens->map(static function (UserApiToken $token) {
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
        foreach ($this->api_tokens as $token) {
            if ($token->getToken() === $uuid) {
                return $token;
            }
        }

        return null;
    }

    public function removeApiToken(UserApiToken $token): void
    {
        if ($this->api_tokens->contains($token)) {
            $this->api_tokens->removeElement($token);
        }
    }

    public function getState() {
        return $this->state;
    }

}
