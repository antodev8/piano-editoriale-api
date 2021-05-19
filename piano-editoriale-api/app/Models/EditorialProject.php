<?php

namespace App\Models;

use App\Jobs\StoreEditorialProjectLogJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use function Illuminate\Events\queueable;

class EditorialProject extends Model
{
   
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'editorial_projects';

    public static function booted()
    {
        static::created(queueable(function ($editorial_project) {
            StoreEditorialProjectLogJob::dispatchAfterResponse(Auth::id(), $editorial_project->id, EditorialProjectLog::ACTION_CREATE);
        }));

        static::updated(queueable(function ($editorial_project) {
            StoreEditorialProjectLogJob::dispatchAfterResponse(Auth::id(), $editorial_project->id, EditorialProjectLog::ACTION_UPDATE);
        }));

        static::deleted(queueable(function ($editorial_project) {
            StoreEditorialProjectLogJob::dispatchAfterResponse(Auth::id(), $editorial_project->id, EditorialProjectLog::ACTION_DESTROY);
        }));
    }


    /************************************************************************************
     * RELATIONS
     */

    /**
     * Get the author
     *
     * @return HasOne
     */
    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id');
    }

    /**
     * Get the sector
     *
     * @return HasOne
     */
    public function sector(): HasOne
    {
        return $this->hasOne(Sector::class, 'id');
    }

    /**
     * Get logs
     *
     * @return HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(EditorialProjectLog::class,'editorial_project_id');
    }
}