<?php

declare(strict_types=1);

namespace common\services;

use common\exceptions\RuntimeException;
use common\models\Apple;
use common\repositories\AppleRepositoryInterface;
use yii\db\ActiveRecord;
use yii\db\Expression;

final readonly class AppleService implements AppleServiceInterface
{
    public function __construct(
        private AppleRepositoryInterface $appleRepository,
    ) {
    }

    public function generate(): void
    {
        for ($i = 0; $i < mt_rand(5, 20); $i++) {
            $apple = new Apple();
            $this->appleRepository->flush(model: $apple);
        }
    }

    /**
     * @throws RuntimeException
     */
    public function fall(int $id): bool
    {
        $apple = $this->getApple(id: $id);

        if (!$apple->isOnTree()) {
            throw new RuntimeException(message: 'Apple already fell');
        }

        $apple->state = Apple::STATE_FELL;
        $apple->fellAt = new Expression(expression: 'NOW()');

        return $this->appleRepository->flush(model: $apple);
    }

    /**
     * @throws RuntimeException
     */
    public function eat(int $id, int $volume): bool
    {
        $apple = $this->getApple(id: $id);

        if (!$apple->isFell()) {
            throw new RuntimeException(message: 'You can eat only apples from the ground');
        }

        $apple->volume -= min($volume, $apple->volume);

        if ($apple->volume <= 0) {
            $apple->deletedAt = new Expression(expression: 'NOW()');
        }

        return $this->appleRepository->flush(model: $apple);
    }

    /**
     * @param int $id
     * @return Apple|ActiveRecord
     * @throws RuntimeException
     */
    private function getApple(int $id): ActiveRecord|Apple
    {
        $apple = $this->appleRepository->find(id: $id);

        if ($apple === null) {
            throw new RuntimeException(message: 'Apple not found');
        }
        return $apple;
    }
}
