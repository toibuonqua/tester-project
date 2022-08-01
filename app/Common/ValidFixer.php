<?php

namespace App\Common;

use Exception;

class ValidFixer
{
    /**
     * In any case that the number is out of range,
     * fix the number to a valid number (in range minValue-maxValue)
     * number < minRange will return minRange
     * number > maxRanage will return maxRange
     *
     * @param Request $request
     * @return void
     */
    public function fixNumberInRange($number, $minValue = null, $maxValue = null)
    {
        $inputType = gettype($number);

        if ($inputType !== 'integer') {
            throw new Exception("Not a number");
        }

        if ($minValue !== null && $number < $minValue) {
            $number = $minValue;
        }

        if ($maxValue !== null && $number > $maxValue) {
            $number = $maxValue;
        }

        return $number;
    }
}
