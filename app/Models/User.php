<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use App\Models\ManagementAccess\Company;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the options for the activity log.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'password',]) // Specify the attributes you want to log
            ->logOnlyDirty() // Log only changed attributes
            ->useLogName('user'); // Specify the log name
    }

    /**
     * Get the description for the given event.
     *
     * @param  string  $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName) : string
    {
        return "User has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'avatar',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts() : array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
