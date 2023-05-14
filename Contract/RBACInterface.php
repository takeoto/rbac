<?php

namespace Takeoto\RBAC\Contract;

interface RBACInterface
{
    /**
     * Checks whether the user has access.
     *
     * @param RBACUserInterface $user
     * @param string $permission
     * @param mixed $payload
     * @return RBACStatusInterface
     */
    public function check(RBACUserInterface $user, string $permission, mixed $payload = null): RBACStatusInterface;

    /**
     * Eligibility Check.
     *
     * @param RBACPermissionInterface $permission
     * @param mixed $payload
     * @return RBACStatusInterface
     */
    public function verify(RBACPermissionInterface $permission, mixed $payload = null): RBACStatusInterface;

    /**
     * Checks if the user has bound a role|permission for yourself.
     *
     * @param RBACUserInterface $user
     * @param RBACRoleInterface|RBACPermissionInterface $item
     * @return bool
     */
    public function has(RBACUserInterface $user, RBACRoleInterface|RBACPermissionInterface $item): bool;

    /**
     * Gets the RBAC manual manager.
     *
     * @return RBACManagerInterface
     */
    public function getManager(): RBACManagerInterface;
}
