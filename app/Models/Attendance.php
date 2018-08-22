<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;

    protected $fillable = ['event_id', 'student_id', 'morning', 'afternoon'];

    protected $dates = ['deleted_at'];

    protected $appends = ['recorded_at', 'day'];

    protected $with = ['student'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getRecordedAtAttribute(){
        if($this->updated_at != null){
            return $this->updated_at->diffForHumans();    
        }
        return $this->created_at->diffForHumans();
    }

    public function getDayAttribute(){
        return $this->created_at->toFormattedDateString(); 
    }

    public function morning(){
        if($this->morning == true){
            return '<i class="green check icon"></i>';
        }
        return '<i class="red remove icon"></i>';
    }
}
