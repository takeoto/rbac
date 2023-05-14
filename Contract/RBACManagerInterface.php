<?php

namespace Takeoto\RBAC\Contract;

use Takeoto\RBAC\Collection\ReadableCollectionInterface;

interface RBACManagerInterface
{
    /**
     * Gets all user available roles collection.
     *
     * @param array<string> $keys
     * @return ReadableCollectionInterface<RBACRoleInterface>
     */
    public function getRoles(array $keys = null): ReadableCollectionInterface;

    /**
     * Makes the reference for the class.
     *
     * @template T of object
     * @param class-string<T> $class
     * @param mixed $data
     * @return T
     */
    public function makeReference(string $class, mixed $data = null): object;

    /** @todo ADVANCED [v2] */
    # public function attachRole(mixed $userIdentifier, RBACRoleInterface $role): bool;
    # public function detachRole(mixed $userIdentifier, RBACRoleInterface $role): bool;
    # public function attachPermission(RBACRoleInterface $role, RBACPermissionInterface $permission): bool;
    # public function detachPermission(RBACRoleInterface $role, RBACPermissionInterface $permission): bool;
    # public function isReference(RBACRoleInterface|RBACPermissionInterface $item): bool;
    # public function create(RBACRoleInterface|RBACPermissionInterface $item): void;
}
