<?php
namespace App\Traits;
use Illuminate\Support\Str;

trait UsesSmartKey
{
    protected static function bootUsesSmartKey()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $prefix = $model->keyPrefix ?? 'SYS';
                $nodeId = str_pad(env('BRANCH_ID', 0), 2, '0', STR_PAD_LEFT);
                $date = date('ymd');
                $random = strtoupper(Str::random(4));
                $model->{$model->getKeyName()} = "{$prefix}-{$nodeId}-{$date}-{$random}";
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
