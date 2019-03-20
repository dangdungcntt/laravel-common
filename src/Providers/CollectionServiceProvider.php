<?php

namespace Nddcoder\Common\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('groupByAndSum', function ($groupByField, $sumFields) {
            return $this->groupBy($groupByField)->mapWithKeys(function ($items, $key) use ($sumFields) {
                return [
                    $key => [
                        'sum' => $items->sumFields($sumFields),
                        'items' => $items
                    ]
                ];
            });
        });

        Collection::macro('sumFields', function ($sumFields) {
            $result = [];
            foreach ($sumFields as $sumField) {
                $result[$sumField] = 0;
            }
            foreach ($this->items as $item) {
                foreach ($sumFields as $sumField) {
                    $result[$sumField] += data_get($item, $sumField);
                }
            }
            return collect($result);
        });

        Collection::macro('convertKeyDateFormat', function ($fromFormat, $toFormat) {
            return $this->mapWithKeys(function ($value, $date) use ($fromFormat, $toFormat) {
                $key = optional(date_create_from_format($fromFormat, $date))->format($toFormat);
                return [$key => $value];
            });
        });
    }
}
