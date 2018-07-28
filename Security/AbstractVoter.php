<?php
declare(strict_types=1);

namespace K3ssen\ExtendedGeneratorBundle\Security;

use K3ssen\ExtendedGeneratorBundle\Model\BlameableEntityInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractVoter implements VoterInterface
{
    /** @var TokenInterface */
    protected $token;

    /** @var RoleHierarchyInterface */
    protected $roleHierarchy;

    /**
     * @required
     */
    public function setRoleHierarchy(RoleHierarchyInterface $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $subject, array $attributes)
    {
        $this->token = $token;
        // abstain vote by default in case none of the attributes are supported
        $vote = self::ACCESS_ABSTAIN;

        foreach ($attributes as $attribute) {
            if (!$this->supports($attribute, $subject)) {
                continue;
            }

            // as soon as at least one attribute is supported, default is to deny access
            $vote = self::ACCESS_DENIED;

            if ($this->voteOnAttribute($attribute, $subject)) {
                // grant access as soon as at least one attribute returns a positive response
                return self::ACCESS_GRANTED;
            }
        }

        return $vote;
    }

    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, (new \ReflectionClass($this))->getConstants(), true);
    }

    abstract protected function voteOnAttribute($attribute, $subject = null): ?bool;

    protected function isSuperAdmin(): bool
    {
        return $this->hasRole('ROLE_SUPER_ADMIN');
    }

    protected function isAdmin(): bool
    {
        return $this->hasRole('ROLE_ADMIN');
    }

    protected function isUser(): bool
    {
        return $this->hasRole('ROLE_USER');
    }

    protected function hasRole(string $roleName): bool
    {
        foreach ($this->roleHierarchy->getReachableRoles($this->getToken()->getRoles()) as $role) {
            if ($roleName === $role->getRole()) {
                return true;
            }
        }
        return false;
    }

    protected function getUser()
    {
        return $this->getToken()->getUser();
    }

    protected function isLoggedIn(): bool
    {
        return $this->getUser() instanceof UserInterface;
    }

    protected function isCreator($object): bool
    {
        if ($object instanceof BlameableEntityInterface) {
            return $object->getCreatedBy() === $this->getUser();
        }
        return false;
    }

    protected function getToken(): TokenInterface
    {
        if (!$this->token) {
            throw new \RuntimeException('Cannot retrieve token before "vote" method has been called.');
        }
        return $this->token;
    }
}
