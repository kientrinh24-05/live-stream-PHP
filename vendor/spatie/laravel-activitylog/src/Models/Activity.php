<?php

namespace Spatie\Activitylog\Models;

use App\Models\members\User;
use App\Traits\Devices;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Spatie\Activitylog\Traits\LogsActivity;

class Activity extends Model implements ActivityContract
{
    use LogsActivity, Devices;
    public $guarded = [];

    protected $casts = [
        'properties' => 'collection',
        'agent' => 'array'
    ];

    protected $filterable = [
        'status',
        'gender'
    ];

    protected $hidden = [
        'password',
        'google_id',
        'email',
    ];

    //Tên nhật ký
    protected static $logName = 'log_action';

    //Tùy chỉnh mô tả
    public function getDescriptionForEvent(string $eventName): string
    {
        return "{$eventName} log_action";
    }

    public function __construct(array $attributes = [])
    {
        if (! isset($this->connection)) {
            $this->setConnection(config('activitylog.database_connection'));
        }

        if (! isset($this->table)) {
            $this->setTable(config('activitylog.table_name'));
        }

        parent::__construct($attributes);
    }

    public function subject(): MorphTo
    {
        if (config('activitylog.subject_returns_soft_deleted_models')) {
            return $this->morphTo()->withTrashed();
        }

        return $this->morphTo();
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    public function getExtraProperty(string $propertyName)
    {
        return Arr::get($this->properties->toArray(), $propertyName);
    }

    public function changes(): Collection
    {
        if (! $this->properties instanceof Collection) {
            return new Collection();
        }

        return $this->properties->only(['attributes', 'old']);
    }

    public function getChangesAttribute(): Collection
    {
        return $this->changes();
    }

    public function scopeInLog(Builder $query, ...$logNames): Builder
    {
        if (is_array($logNames[0])) {
            $logNames = $logNames[0];
        }

        return $query->whereIn('log_name', $logNames);
    }

    public function scopeCausedBy(Builder $query, Model $causer): Builder
    {
        return $query
            ->where('causer_type', $causer->getMorphClass())
            ->where('causer_id', $causer->getKey());
    }

    public function scopeForSubject(Builder $query, Model $subject): Builder
    {
        return $query
            ->where('subject_type', $subject->getMorphClass())
            ->where('subject_id', $subject->getKey());
    }

    public function scopeUser($query)
    {
        $query->addSelect(['name' => User::select('name')
            ->whereColumn('causer_id', 'users.id')
            ->limit(1)
        ])->addSelect(['position' => User::select('position')
            ->whereColumn('causer_id', 'users.id')
            ->limit(1)
        ]);
    }

    public function activityUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id', 'id');
    }

    public function filterName($query, $value)
    {
        return $query->where('log_name', 'LIKE', '%' . $value . '%');
    }

    public function filterDescription($query, $value)
    {
        return $query->where('description', $value);
    }

    public function filterUser($query, $value)
    {
        return $query->where('causer_id', $value);
    }

    // Chuyển đổi định dạng date
    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    // Chuyển đổi định dạng date
    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    // Chuyển đổi định dạng date
    public function getBannedUntilAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

//    public function filterPosition($query, $value)
//    {
//        return $query->where('position', $value);
//    }
}
