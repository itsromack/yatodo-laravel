<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item',
        'due_date',
        'is_completed',
        'owner_id'
    ];

    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function getDueDate($format = false)
    {
        if ($format == true)
        {
            return $this->getFormattedDueDate();
        }
        return $this->due_date;
    }

    public function setDueDate($due_date = null)
    {
        if (!is_null($due_date))
        {
            $this->due_date = $due_date;
        }
    }

    public function getFormattedDueDate()
    {
        if (!is_null($this->due_date))
        {
            $dt = new Carbon($this->due_date);
            return $dt->toFormattedDateString();
        }
        return null;
    }

    public function isCompleted()
    {
        return ($this->is_completed == 1);
    }

    public static function createTask(
        $owner_id,
        $item,
        $due_date = null,
        $is_completed = null
    )
    {
        $task = new static;
        $task->item = $item;
        $task->owner_id = $owner_id;
        if (!is_null($due_date))
        {
            $task->due_date = $due_date;
        }
        if (!is_null($is_completed))
        {
            $task->is_completed = $is_completed;
        }
        if ($task->save() == true)
        {
            return static::find($task->id);
        }
        return false;
    }

    public static function updateTask(
        $task_id,
        $item,
        $due_date = null,
        $is_completed = null
    )
    {
        $task = static::find($task_id);
        if (!is_null($task))
        {
            $task->item = $item;
            if (!is_null($due_date))
            {
                $task->due_date = $due_date;
            }
            if (!is_null($is_completed))
            {
                $task->is_completed = $is_completed;
            }
            if ($task->save() == true)
            {
                return $task;
            }
        }
        return false;
    }

    public function setCompleted()
    {
        $this->is_completed = true;
        return $this->save();
    }

    public function setNotCompleted()
    {
        $this->is_completed = false;
        return $this->save();
    }

    public function updateItem(
        $item,
        $due_date = null,
        $is_completed = null
    )
    {
        $this->item = $item;
        if (!is_null($due_date))
        {
            $this->due_date = $due_date;
        }
        if (!is_null($is_completed) and is_bool($is_completed))
        {
            $this->is_completed = $is_completed;
        }
        return $this->save();
    }
}
