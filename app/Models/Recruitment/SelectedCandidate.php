<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SelectedCandidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'selection_id',
        'file_selected_candidate',
        'description',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function selection()
    {
        return $this->belongsTo(Selection::class);
    }
}
