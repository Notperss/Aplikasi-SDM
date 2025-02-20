<?php

namespace App\Models\FolderDivision;

use App\Models\WorkUnit\Division;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Models\ManagementAccess\Company;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\FolderDivision\FolderDivision;

class FolderItemFile extends Model
{
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
                'folder_division_id',
                'company_id',
                'division_id',
                'number',
                'date',
                'description',
                'file',
                'is_lock',

                'notification',
                'date_notification',
                'email',
                'email_cc',
                'attach_file',

                'tag',
                'box_number_id',
                'file_number_id',
            ]) // Specify the attributes you want to log
            ->logOnlyDirty() // Log only changed attributes
            ->useLogName('folder-file'); // Specify the log name
    }

    /**
     * Get the description for the given event.
     *
     * @param  string  $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "folder file has been {$eventName}";
    }


    protected $fillable = [
        'folder_division_id',
        'company_id',
        'division_id',
        'number',
        'date',
        'description',
        'file',
        'is_lock',


        'notification',
        'date_notification',
        'email',
        'email_cc',
        'attach_file',

        'tag',
        'box_number_id',
        'file_number',
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

    public function folder()
    {
        // 2 parameter (path model, field foreign key)
        return $this->belongsTo(FolderDivision::class, 'folder_division_id');
    }

    public function boxNumber()
    {
        return $this->belongsTo(BoxNumber::class);
    }
}
