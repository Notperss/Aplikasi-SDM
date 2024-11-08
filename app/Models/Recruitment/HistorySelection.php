<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySelection extends Model
{
    use HasFactory;

    protected $fillable = [
        'selection_id',
        'date',
        'name_process',
        'description',
    ];

    public function selection()
    {
        return $this->belongsTo(Selection::class);
    }
}
