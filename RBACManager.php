<?php

declare(strict_types=1);

namespace Takeoto\RBAC;

use Takeoto\RBAC\Collection\ReadableCollectionInterface;
use Takeoto\RBAC\Collection\ReadOnlyCollection;
use Takeoto\RBAC\Contract\RBACBuilderProviderInterface;
use Takeoto\RBAC\Contract\RBACManagerInterface;
use Takeoto\RBAC\Contract\RBACRoleInterface;
use Takeoto\RBAC\Contract\RBACStorageInterface;

class RBACManager implements RBACManagerInterface
{
    public function __construct(
        private readonly RBACStorageInterface $storage,
        private readonly RBACBuilderProviderInterface $builderProvider,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles(array $keys = null): ReadableCollectionInterface
    {
        $roles = $this->storage->getRoles($keys);

        $items = [];

        foreach ($roles as $roleData) {
            /** @var RBACRoleInterface $role */
            $role = $this->makeReference(RBACRoleInterface::class, $roleData);
            $items[$role->getKey()] = $role;
        }

        return new ReadOnlyCollection($items);
    }

    /**
     * {@inheritDoc}
     */
    public function makeReference($class, mixed $data = null): object
    {
        $builder = $this->builderProvider->for($class);

        if (!$builder->verify($data)) {
            throw new \RuntimeException(sprintf('Cannot create "%s", because a data is not valid!', $class));
        }

        return $builder->build($data);
    }
}
