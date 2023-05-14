<?php

namespace Takeoto\RBAC\Contract;

interface RBACBuilderProviderInterface
{
    /**
     * Gets the builder by a class name.
     *
     * @template T
     * @param class-string<T> $class
     * @return RBACBuilderInterface<T>
     */
    public function for(string $class): RBACBuilderInterface;
}
