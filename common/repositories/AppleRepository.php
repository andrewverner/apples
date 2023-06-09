<?php

declare(strict_types=1);

namespace common\repositories;

use common\models\Apple;
use yii\db\ActiveRecord;

final readonly class AppleRepository implements AppleRepositoryInterface
{
    public function find(int $id): Apple|ActiveRecord|null
    {
        return Apple::find()
            ->where(condition: [
                'id' => $id,
                'deletedAt' => null,
            ])
            ->one();
    }

    public function flush(Apple $model): bool
    {
        return $model->save();
    }
}
