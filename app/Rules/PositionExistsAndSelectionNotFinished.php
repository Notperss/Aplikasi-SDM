<?php

namespace App\Rules;

use Closure;
use App\Models\Recruitment\Selection;
use Illuminate\Contracts\Validation\ValidationRule;

class PositionExistsAndSelectionNotFinished implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        // If $value is an array, validate each position ID
        if (is_array($value)) {
            foreach ($value as $positionId) {
                if (Selection::where('is_finished', false)
                    ->whereHas('selectedPositions', function ($query) use ($positionId) {
                        $query->where('position_id', $positionId);
                    })->exists()) {
                    $fail("The position with ID {$positionId} must be part of an unfinished selection.");
                }
            }
        } else {
            // If $value is a single ID, validate it directly
            if (Selection::where('is_finished', false)
                ->whereHas('selectedPositions', function ($query) use ($value) {
                    $query->where('position_id', $value);
                })->exists()) {
                $fail('The :attribute must be part of an unfinished selection.');
            }
        }
    }
}
