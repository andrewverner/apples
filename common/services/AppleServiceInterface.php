<?php

declare(strict_types=1);

namespace common\services;

interface AppleServiceInterface
{
    public function generate(): void;

    public function fall(int $id): bool;
}