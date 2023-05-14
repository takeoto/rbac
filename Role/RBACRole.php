<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Role;

use Takeoto\RBAC\Attributable\TraitReadableAttributes;
use Takeoto\RBAC\Collection\ReadableCollectionInterface;
use Takeoto\RBAC\Contract\RBACRoleInterface;

class RBACRole implements RBACRoleInterface
{
    use TraitReadableAttributes;

    public function __construct(
        private readonly mixed $key,
        private readonly ReadableCollectionInterface $permissions,
        private array $attributes = [],
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * {@inheritDoc}
     */
    public function getPermissions(): ReadableCollectionInterface
    {
        return $this->permissions;
    }
}
