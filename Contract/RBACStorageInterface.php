<?php

namespace Takeoto\RBAC\Contract;

interface RBACStorageInterface
{
    /**
     * Gets the role data by the role key.
     *
     * @param string $roleKey
     * @return array
     */
    public function getRole(string $roleKey): array;

    /**
     * Gets all available roles.
     *
     * @return mixed[]
     */
    public function getRoles(array $keys = null): array;

    /**
     * Gets the permission data by key.
     *
     * @param string $permissionKey
     * @return mixed[]
     */
    public function getPermission(string $permissionKey): array;

    /**
     * Gets all available permissions.
     *
     * @return mixed[]
     */
    public function getPermissions(): array;

    /**
     * Gets all available role permissions by the role key.
     *
     * @todo ADVANCED [v2] - this is not the storage's responsibility.
     * @param string $roleKey
     * @return mixed[]
     */
    public function getRolePermissions(string $roleKey): array;

    /** @todo ADVANCED [v2] */
    # public function addRoleToUser(string $roleKey, string $userIdentifier);
    # public function addPermissionToRole(string $permissionKey, string $roleKey);
}
