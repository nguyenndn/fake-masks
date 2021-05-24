<?php

namespace Modules\ObjectAppearance\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'camera_id', 'people_entering', 'people_have_mask', 'people_no_mask', 'minutes', 'hours', 'date', 'month', 'year'
    ];
}
