<?php

namespace RenokiCo\LaravelSteampipe;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Str;

abstract class Model extends BaseModel
{
    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'steampipe';

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table ?? Str::of(get_class($this))
            ->replace('RenokiCo\\LaravelSteampipe\\', '')
            ->replace('App\\SteamPipe\\Aws\\', '')
            ->snake()
            ->replace('\\', '');
    }
}
