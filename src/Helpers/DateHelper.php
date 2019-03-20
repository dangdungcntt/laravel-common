<?php
/**
 * Created by PhpStorm.
 * User: dangdung
 * Date: 04/03/2019
 * Time: 14:22
 */

namespace Pushtimze\Common\Helpers;

use Illuminate\Support\Carbon;

class DateHelper
{
    /**
     * @param string|int $time
     * @param string|null $format
     * @return Carbon
     */
    public static function parse($time, $format = null)
    {
        return is_numeric($time)
            ? Carbon::createFromTimestamp($time)
            : (empty($format)
                ? Carbon::parse($time)
                : Carbon::createFromFormat($format, $time));
    }

    /**
     * @param string|int $startDate
     * @param string|int $endDate
     * @param bool $millisecond
     * @param string|null $format
     * @return array
     */
    public static function buildTimeQuery($startDate, $endDate, $millisecond = true, $format = null)
    {
        $start = self::parse($startDate, $format);
        $end = self::parse($endDate, $format);

        if (! $start->isStartOfDay()) {
            $start->setTimestamp(strtotime('tomorrow', $start->getTimestamp()));
        }

        $milli = $millisecond ? 1000 : 1;

        return [
            'start_date' => $start->getTimestamp() * $milli,
            'end_date' => strtotime('tomorrow', $end->getTimestamp()) * $milli - 1
        ];
    }

    public static function buildDateRangeFromTime($startDate, $endDate, $inputFormat = null, $outputFormat = 'Y-m-d', $prefix = '', $suffix = '')
    {
        $start = self::parse($startDate, $inputFormat)
            ->setTime(0, 0, 0)
            ->getTimestamp();
        $end = self::parse($endDate, $inputFormat)
            ->setTime(0, 0, 0)
            ->getTimestamp();

        $result = [];

        for ($i = $start; $i <= $end; $i += 86400) {
            $result[] = $prefix . Carbon::createFromTimestamp($i)->format($outputFormat) . $suffix;
        }

        return $result;
    }

}
