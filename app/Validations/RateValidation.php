<?php


namespace App\Validations;

use App\Models\Rate;
use Carbon\Carbon;


class RateValidation
{
    public function compareTime(): bool
    {
        $rate = Rate::find(1);

        if ($rate === null) {
            return true;
        }

        $lastRateUpdate = $rate->created_at->diffInMinutes(Carbon::now());

        return $lastRateUpdate > 5;
    }
}
