<?php

declare(strict_types=1);

namespace common\repositories;

use common\models\Apple;
use yii\db\ActiveRecord;

interface AppleRepositoryInterface
{
    public function find(int $id): Apple|ActiveRecord|null;

    public function flush(Apple $model): bool;
}
