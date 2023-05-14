<?php

declare(strict_types=1);

namespace Takeoto\RBAC;

use Takeoto\RBAC\Collection\ReadableCollectionInterface;
use Takeoto\RBAC\Contract\RBACInterface;
use Takeoto\RBAC\Contract\RBACManagerInterface;
use Takeoto\RBAC\Contract\RBACPermissionInterface;
use Takeoto\RBAC\Contract\RBACRestrictionProviderInterface;
use Takeoto\RBAC\Contract\RBACRoleInterface;
use Takeoto\RBAC\Contract\RBACStatusInterface;
use Takeoto\RBAC\Contract\RBACUserInterface;

class RBAC implements RBACInterface
{
    public function __construct(
        private readonly RBACRestrictionProviderInterface $restrict,
        private readonly RBACManagerInterface $manager,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function check(RBACUserInterface $user, string $permission, mixed $payload = null): RBACStatusInterface
    {
        $status = null;
        $roles = $user->getRoles();

        /** @var RBACRoleInterface $role */
        foreach ($this->rolesWalk($roles) as $role) {
            $item = $role->getPermissions()->get($permission);

            if ($item === null) {
                continue;
            }

            $status = $this->verify($item, $payload);
            break;
        }

        return $status ?? new RBACStatus(false);
    }

    /**
     * {@inheritDoc}
     */
    public function has(RBACUserInterface $user, RBACRoleInterface|RBACPermissionInterface $item): bool
    {
        $roles = $user->getRoles();
        $has = $item instanceof RBACRoleInterface
            ? fn(RBACRoleInterface $role): bool => $role->getKey() === $item->getKey()
            : fn(RBACRoleInterface $role): bool => $role->getPermissions()->containsKey($item->getKey());

        foreach ($this->rolesWalk($roles) as $role) {
            if ($has($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function verify(RBACPermissionInterface $permission, mixed $payload = null): RBACStatusInterface
    {
        return $this->restrict->for($permission)->claimed($payload);
    }

    /**
     * {@inheritDoc}
     */
    public function getManager(): RBACManagerInterface
    {
        return $this->manager;
    }

    /**
     * @param ReadableCollectionInterface<RBACRoleInterface> $collection
     * @return \Traversable<RBACRoleInterface>
     */
    protected function rolesWalk(ReadableCollectionInterface $collection): \Traversable
    {
        return $collection;
    }
}
