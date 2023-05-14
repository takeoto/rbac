<?php

namespace Takeoto\RBAC\Contract;

use Takeoto\RBAC\Attributable\Contract\ReadableAttributesInterface;
use Takeoto\RBAC\Collection\ReadableCollectionInterface;

interface RBACPermissionInterface extends ReadableAttributesInterface
{
    /**
     * Gets key of permission.
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Gets the permission arguments.
     *
     * @return ReadableCollectionInterface
     */
    public function getArguments(): ReadableCollectionInterface;
}
