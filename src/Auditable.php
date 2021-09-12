<?php

namespace Pharaonic\Laravel\Audits;

use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    /**
     * Init Auditable Package
     * Add `created_by`, `updated_by`, `deleted_by` fields to fillable list.
     *
     * @return void
     */
    public function initializeAuditable()
    {
        if ($this->timesamps)
            array_push($this->fillable, 'created_by', 'updated_by');

        if (is_bool($this->forceDeleting ?? null))
            $this->fillable[] = 'deleted_by';
    }

    /**
     * Boot Auditable Package
     * Create Eloquent Events (Creating, Updating)
     *
     * @return void
     */
    protected static function bootAuditable()
    {
        $user = Auth::id();

        // Creating && Updating
        self::saving(function ($item) use ($user) {
            if ($item->timestamps)
                if (!$item->getKey()) {
                    // Creating
                    $item->created_by = $user;
                } else {
                    // Updating
                    $item->updated_by = $user;
                }
        });

        // Deleting
        static::deleting(function ($item) use ($user) {
            if (is_bool($item->forceDeleting ?? null))
                if (!$item->forceDeleting) {
                    // SOFT
                    $item->deleted_by = $user;
                    $item->save();
                }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        $model = config('auth.providers.users.model', config('auth.providers.users.model', User::class));
        return $this->belongsTo($model, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        $model = config('auth.providers.users.model', config('auth.providers.users.model', User::class));
        return $this->belongsTo($model, 'updated_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletedBy()
    {
        $model = config('auth.providers.users.model', config('auth.providers.users.model', User::class));
        return $this->belongsTo($model, 'deleted_by');
    }
}
