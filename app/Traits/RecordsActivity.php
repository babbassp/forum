<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Str;

trait RecordsActivity
{

    /**
     * Boot the trait.
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($instance) use ($event) {
                $instance->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    /**
     * Returns all the model events that need to be recorded.
     *
     * @return array
     */
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    /**
     * Record new activity for the model.
     *
     * @param string $event
     */
    protected function recordActivity(string $event): void
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type'    => $this->getActivityType($event)
        ]);
    }


    /**
     * Converts and then returns the model instance name with the event name in snake case form.
     *
     * @param string $event
     * @return string
     */
    protected function getActivityType($event)
    {
        return Str::snake($event . class_basename($this));
    }

    /**
     * Get the model instance's activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}