<?php

declare(strict_types=1);

namespace common\models;

use DateTime;
use Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $state
 * @property string|null $color
 * @property int $volume
 * @property string $createdAt
 * @property string|null $fellAt
 * @property string|null $deletedAt
 */
class Apple extends ActiveRecord
{
    public const STATE_ON_TREE = 'on tree';
    public const STATE_FELL = 'fell';
    public const STATE_ROTTEN = 'rotten';

    private const COLORS = [
        'red',
        'green',
        'yellow',
    ];

    public function __construct($config = [])
    {
        $this->color = self::COLORS[array_rand(array: self::COLORS)];

        parent::__construct(config: $config);
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => null,
                'value' => new Expression(expression: 'NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['state', 'color'], 'string'],
            [['volume'], 'integer'],
            [['createdAt', 'fellAt', 'deletedAt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'state' => 'State',
            'color' => 'Color',
            'volume' => 'Volume',
            'createdAt' => 'Created At',
            'fellAt' => 'Fell At',
            'deletedAt' => 'Deleted At',
        ];
    }

    public function isOnTree(): bool
    {
        return $this->state === self::STATE_ON_TREE;
    }

    public function isFell(): bool
    {
        return $this->state === self::STATE_FELL;
    }

    public function isRotten(): bool
    {
        return $this->state === self::STATE_ROTTEN;
    }

    /**
     * @throws Exception
     */
    public function afterFind(): void
    {
        if ($this->state === self::STATE_ROTTEN) {
            return;
        }

        $diff = (new DateTime($this->createdAt))->diff(new DateTime());

        if ($diff->h >= 5) {
            $this->state = self::STATE_ROTTEN;
            $this->save();
        }
    }
}
