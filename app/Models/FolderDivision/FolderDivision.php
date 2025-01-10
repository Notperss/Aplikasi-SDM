<?php

namespace App\Models\FolderDivision;

use Kalnoy\Nestedset\NodeTrait;
use App\Models\WorkUnit\Division;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Models\ManagementAccess\Company;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\FolderDivision\FolderItemFile;

class FolderDivision extends Model
{
    use NodeTrait;
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    /**
     * Get the options for the activity log.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    protected static $recordEvents = ['deleted', 'created'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'description',
            ]) // Specify the attributes you want to log
            ->logOnlyDirty() // Log only changed attributes
            ->useLogName('folder'); // Specify the log name
    }

    /**
     * Get the description for the given event.
     *
     * @param  string  $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "folder has been {$eventName}";
    }

    protected $fillable = [
        'company_id',
        'division_id',
        'name',
        'description',
        'is_lock',
    ];

    public function company()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function division()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function folder_file()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasMany(FolderItemFile::class, 'folder_division_id', 'id');
    }
}
