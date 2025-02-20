<?php

namespace App\Models\FolderDivision;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoxNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'box_number',
        'description',
    ];

    public function folderFiles()
    {
        return $this->hasMany(FolderItemFile::class);
    }
}
