<?php

namespace Takeoto\RBAC\Contract;

use Takeoto\RBAC\Attributable\Contract\ReadableAttributesInterface;
use Takeoto\RBAC\Collection\ReadableCollectionInterface;

interface RBACRoleInterface extends ReadableAttributesInterface
{
    /**
     * Gets the key of role.
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Gets all the permissions that belong to the current role.
     *
     * @return ReadableCollectionInterface<RBACPermissionInterface>
     */
    public function getPermissions(): ReadableCollectionInterface;

    /** @todo ADVANCED [v2] */
    # public function getChildren(): ReadableCollectionInterface;
    # public function getParent(): ?RBACRoleInterface;
}
