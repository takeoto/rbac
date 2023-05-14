<?php

declare(strict_types=1);

namespace Takeoto\RBAC\Permission;

use Takeoto\RBAC\Attributable\TraitReadableAttributes;
use Takeoto\RBAC\Collection\ReadableCollectionInterface;
use Takeoto\RBAC\Collection\ReadOnlyCollection;
use Takeoto\RBAC\Contract\RBACPermissionInterface;

class RBACPermission implements RBACPermissionInterface
{
    use TraitReadableAttributes;

    public function __construct(
        private readonly string $key,
        private readonly array $arguments,
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
    public function getArguments(): ReadableCollectionInterface
    {
        return new ReadOnlyCollection($this->arguments);
    }
}
