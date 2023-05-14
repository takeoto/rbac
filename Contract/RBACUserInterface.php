<?php

namespace Takeoto\RBAC\Contract;

use Takeoto\RBAC\Collection\ReadableCollectionInterface;

interface RBACUserInterface
{
    /**
     * Gets the user identifier.
     *
     * @return mixed
     */
    public function getUserIdentifier(): mixed;

    /**
     * Gets all user available roles.
     *
     * @return ReadableCollectionInterface<RBACRoleInterface>
     */
    public function getRoles(): ReadableCollectionInterface;

    /**
     * Checks whether the user has access.
     *
     * @param string $permission
     * @param mixed $payload
     * @return bool
     */
    public function isGranted(string $permission, mixed $payload = null): bool;
}
