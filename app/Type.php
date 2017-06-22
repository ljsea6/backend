<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'types';

    public function types()
    {
        return $this->hasMany(Type::class, 'type_id', 'id');
    }
}
