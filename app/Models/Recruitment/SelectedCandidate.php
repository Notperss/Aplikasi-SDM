<?php

namespace App\Models\Recruitment;

use App\Models\Approval\Approval;
use App\Models\Position\Position;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SelectedCandidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'position_id',
        'selection_id',
        'file_selected_candidate',
        'description',
        'is_approve',
        'is_hire',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function selection()
    {
        return $this->belongsTo(Selection::class);
    }
    public function approval()
    {
        return $this->hasOne(Approval::class);
    }


}
