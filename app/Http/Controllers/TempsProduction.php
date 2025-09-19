<?php

namespace App\Http\Controllers;

use Cmixin\BusinessDay;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class TempsProduction extends Controller
{
    public function tempsProduction()
    {

        $vendredi_travail =1;

        // $start = Carbon::createFromFormat('d/m/Y H:i', '04/09/2025 08:30');
        // $end = Carbon::createFromFormat('d/m/Y H:i', '10/09/2025 13:48');

        $start = Carbon::createFromFormat('d/m/Y H:i', '04/09/2025 08:30');
        $end = Carbon::createFromFormat('d/m/Y H:i', '10/09/2025 13:48');

        $workingSlots = [
            ['7:00', '09:30'],
            ['09:45', '12:00'],
            ['12:30', '15:00'],
            ['15:15', '16:45'],
        ];

        $workingSlotsVend = [
            ['7:00', '09:30'],
            ['09:50', '12:00'],
        ];

        $totalMinutes = 0;

        $period = CarbonPeriod::create($start->copy()->startOfDay(), '1 day', $end);

        foreach ($period as $day) {
            if ($day->isFriday() && $vendredi_travail === 0) {
                continue;
            }

            if ($day->isSaturday() || $day->isSunday()) {
                continue;
            }

            if (!$day->isFriday()) {
                foreach ($workingSlots as [$slotStart, $slotEnd]) {

                    $slotStartTime = $day->copy()->setTimeFromTimeString($slotStart);
                    $slotEndTime   = $day->copy()->setTimeFromTimeString($slotEnd);

                    $rangeStart = $start->greaterThan($slotStartTime) ? $start : $slotStartTime;
                    $rangeEnd   = $end->lessThan($slotEndTime) ? $end : $slotEndTime;

                    if ($rangeEnd->greaterThan($rangeStart)) {
                        $totalMinutes += $rangeStart->diffInMinutes($rangeEnd);
                    }
                }
            } else {
                foreach ($workingSlotsVend as [$slotStart, $slotEnd]) {

                    $slotStartTime = $day->copy()->setTimeFromTimeString($slotStart);
                    $slotEndTime   = $day->copy()->setTimeFromTimeString($slotEnd);

                    $rangeStart = $start->greaterThan($slotStartTime) ? $start : $slotStartTime;
                    $rangeEnd   = $end->lessThan($slotEndTime) ? $end : $slotEndTime;

                    if ($rangeEnd->greaterThan($rangeStart)) {
                        $totalMinutes += $rangeStart->diffInMinutes($rangeEnd);
                    }
                }

                $vendredi_travail--;
            }
        }
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        $result = sprintf('%02d:%02d', $hours, $minutes);

        echo $result;
    }
}
