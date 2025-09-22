<?php

namespace App\Http\Controllers;

use Cmixin\BusinessDay;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class TempsProduction extends Controller //TODO Jour fériés et fermetures
{
    public function tempsProduction(string $startDate,string $endDate,?int $vendredi_travail=0)
    {

        //$vendredi_travail = 1;

        $start = Carbon::createFromFormat('d/m/Y H:i', $startDate);
        $end = Carbon::createFromFormat('d/m/Y H:i', $endDate);

        $workingSlotsWeek = [
            ['7:00', '09:30'],
            ['09:45', '12:00'],
            ['12:30', '15:00'],
            ['15:15', '16:45'],
        ];

        $workingSlotsSupp = [
            ['7:00', '09:30'],
            ['09:50', '12:00'],
        ];

        $totalMinutes = 0;

        $period = CarbonPeriod::create($start->copy()->startOfDay(), '1 day', $end);

        foreach ($period as $day) {
            if ($day->isFriday() && $vendredi_travail === 0) {
                continue;
            }

            if ($day->isFriday()) $vendredi_travail--;

            if ($day->isSaturday() || $day->isSunday()) {
                continue;
            }

            $workingSlots =  $day->isFriday() ? $workingSlotsSupp : $workingSlotsWeek;


            foreach ($workingSlots as [$slotStart, $slotEnd]) {

                $slotStartTime = $day->copy()->setTimeFromTimeString($slotStart);
                $slotEndTime   = $day->copy()->setTimeFromTimeString($slotEnd);

                $rangeStart = $start->greaterThan($slotStartTime) ? $start : $slotStartTime;
                $rangeEnd   = $end->lessThan($slotEndTime) ? $end : $slotEndTime;

                if ($rangeEnd->greaterThan($rangeStart)) {
                    $totalMinutes += $rangeStart->diffInMinutes($rangeEnd);
                }
            }
        }

        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        $result = sprintf('%02dh%02dmin', $hours, $minutes);

        echo $result;
    }
}
