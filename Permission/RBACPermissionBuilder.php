<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Permission;

use Takeoto\RBAC\Contract\RBACBuilderInterface;
use Takeoto\RBAC\Contract\RBACPermissionInterface;

/**
 * @template T
 * @template-implements RBACBuilderInterface<RBACPermissionInterface>
 */
class RBACPermissionBuilder implements RBACBuilderInterface
{
    /**
     * {@inheritDoc}
     */
    public function build(mixed $params = null)
    {
        return new RBACPermission(
            $params[PermissionDict::KEY],
            $params[PermissionDict::ARGUMENTS],
            $params[PermissionDict::ATTRIBUTES] ?? [],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function verify(mixed $params = null): bool
    {
        return
            is_array($params)
            && isset($params[PermissionDict::KEY])
            && is_string($params[PermissionDict::KEY])
            && !empty($params[PermissionDict::KEY])
            && isset($params[PermissionDict::ARGUMENTS])
            && is_array($params[PermissionDict::ARGUMENTS]);
    }
}
