<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'competency',
        'subject_id',
    ];

    protected $with = ['subject'];

    /**
     * Get the subject that owns the topic.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function my_class()
    {
        return $this->belongsTo(MyClass::class);
    }

    /**
     * Scope a query to only include topics for a specific subject.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $subjectId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForSubject($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }

    /**
     * Get the display name of the topic with subject name.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . ($this->subject->name ?? 'N/A') . ')';
    }
}
