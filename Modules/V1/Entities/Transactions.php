<?php

namespace Modules\V1\Entities;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [];
    protected $table = 'transaction';

    public function category(){
        return $this->belongsTo('Modules\V1\Entities\Category','category_id');
    }
}
