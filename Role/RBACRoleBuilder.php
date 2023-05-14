<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Role;

use Takeoto\RBAC\Collection\ReadableCollectionInterface;
use Takeoto\RBAC\Collection\ReadOnlyCollection;
use Takeoto\RBAC\Contract\RBACBuilderInterface;
use Takeoto\RBAC\Contract\RBACManagerInterface;
use Takeoto\RBAC\Contract\RBACPermissionInterface;
use Takeoto\RBAC\Contract\RBACRoleInterface;
use Takeoto\RBAC\Contract\RBACStorageInterface;

/**
 * @template T
 * @template-implements RBACBuilderInterface<RBACRoleInterface>
 */
class RBACRoleBuilder implements RBACBuilderInterface
{
    public function __construct(
        private readonly RBACStorageInterface $storage,
        private readonly RBACManagerInterface $manager,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function build(mixed $params = null)
    {
        return new RBACRole(
            $key = $params[RoleDict::KEY],
            $this->getPermissions($key, $params[RoleDict::PERMISSIONS] ?? null),
            $params[RoleDict::ATTRIBUTES] ?? [],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function verify(mixed $params = null): bool
    {
        return
            is_array($params)
            && isset($params[RoleDict::KEY])
            && is_string($params[RoleDict::KEY])
            && !empty($params[RoleDict::KEY])
            && (!isset($params[RoleDict::PERMISSIONS]) || is_array($params[RoleDict::PERMISSIONS]));
    }

    /**
     * Gets the permission collection for the role.
     *
     * @param string $roleKey
     * @param mixed[]|null $permissions
     * @return ReadableCollectionInterface<RBACPermissionInterface>
     */
    public function getPermissions(string $roleKey, ?array $permissions): ReadableCollectionInterface
    {
        $permissions = $permissions === null
            ? $this->storage->getRolePermissions($roleKey)
            : $permissions;
        $items = [];

        foreach ($permissions as $permissionData) {
            $permission = $this->manager->makeReference(RBACPermissionInterface::class, $permissionData);
            $items[$permission->getKey()] = $permission;
        }

        return new ReadOnlyCollection($items);
    }
}
