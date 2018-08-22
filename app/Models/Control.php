<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Control extends Model
{
    use SoftDeletes;

    protected $fillable = ['event_id', 'from_morning', 'to_morning', 'from_afternoon', 'to_afternoon', 'all_day'];

    protected $dates = ['deleted_at'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
