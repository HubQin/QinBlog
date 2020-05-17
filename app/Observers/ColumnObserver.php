<?php

namespace App\Observers;

use App\Column;

/**
 * 导航栏目模型事件
 * Class ColumnObserver
 * @package App\Observers
 */
class ColumnObserver
{
    public function saved(Column $column)
    {
        $this->forgetColumnCache();
    }

    public function deleted(Column $column)
    {
        $this->forgetColumnCache();
    }

    private function forgetColumnCache()
    {
        cache()->forget('columns');
    }
}
