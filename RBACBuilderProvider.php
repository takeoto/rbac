<?php

declare(strict_types=1);

namespace Takeoto\RBAC;

use Takeoto\RBAC\Contract\RBACBuilderInterface;
use Takeoto\RBAC\Contract\RBACBuilderProviderInterface;

class RBACBuilderProvider implements RBACBuilderProviderInterface
{
    /**
     * @var array<class-string,RBACBuilderInterface>
     */
    private array $builders;

    /**
     * {@inheritDoc}
     *
     * @template T
     * @param class-string<T> $class
     * @return RBACBuilderInterface<T>
     */
    public function for(string $class): RBACBuilderInterface
    {
        if (!isset($this->builders[$class])) {
            throw new \RuntimeException(sprintf('Builder for "%s" doesn\'t exist!', $class));
        }

        return $this->builders[$class];
    }

    /**
     * Binds the builder for the class.
     *
     * @template T
     * @param class-string<T> $class
     * @param RBACBuilderInterface<T> $builder
     * @return void
     */
    public function register(string $class, RBACBuilderInterface $builder): void
    {
        $this->builders[$class] = $builder;
    }
}
