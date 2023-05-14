<?php

declare(strict_types=1);

namespace Takeoto\RBAC;

use Takeoto\RBAC\Contract\RBACStatusInterface;

class RBACStatus implements RBACStatusInterface
{
    public function __construct(
        private ?bool $allowed = null,
        private readonly array $errors = [],
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function isAllowed(): bool
    {
        return $this->allowed ??= (bool)$this->errors;
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
