<?php

namespace App\Livewire;

use App\Models\Court;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CourtList extends Component
{
    public $search = '';
    public $city = '';
    public $price = '';
    public $sort = 'latest';

    // RESET SEMUA FILTER
    public function resetFilters()
    {
        $this->reset([
            'search',
            'city',
            'price',
            'sort',
        ]);
    }

    public function render()
    {
        // CACHE KEY BERDASARKAN FILTER
        $cacheKey = 'courts_v2_' . md5(json_encode([
            'search' => trim($this->search),
            'city' => $this->city,
            'price' => $this->price,
            'sort' => $this->sort,
        ]));

        // CACHE ID LAPANGAN
        $courtIds = Cache::remember($cacheKey, 60, function () {

            $query = Court::where('status', 'active');

            // SEARCH
            if (trim($this->search) !== '') {

                $keyword = '%' . trim($this->search) . '%';

                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', $keyword)
                        ->orWhere('venue_name', 'like', $keyword)
                        ->orWhere('city', 'like', $keyword)
                        ->orWhere('province', 'like', $keyword);
                });
            }

            // FILTER KOTA
            if ($this->city !== '') {
                $query->where('city', $this->city);
            }

            // FILTER HARGA
            if ($this->price === 'low') {

                $query->where('price_per_hour', '<=', 100000);

            } elseif ($this->price === 'medium') {

                $query->where('price_per_hour', '>', 100000)
                    ->where('price_per_hour', '<', 150000);

            } elseif ($this->price === 'high') {

                $query->where('price_per_hour', '>=', 150000);

            }

            // SORTING
            if ($this->sort === 'lowest') {

                $query->orderBy('price_per_hour', 'asc');

            } elseif ($this->sort === 'highest') {

                $query->orderBy('price_per_hour', 'desc');

            } else {

                $query->latest();

            }

            return $query->pluck('id')->all();
        });

        // AMBIL DATA BERDASARKAN ID YANG SUDAH DI-CACHE
        $courts = Court::where('status', 'active')
            ->whereIn('id', $courtIds)
            ->get()
            ->sortBy(function ($court) use ($courtIds) {
                return array_search($court->id, $courtIds);
            })
            ->values();

        // CACHE DAFTAR KOTA
        $cities = Cache::remember('courts_active_cities', 60, function () {

            return Court::where('status', 'active')
                ->whereNotNull('city')
                ->distinct()
                ->orderBy('city')
                ->pluck('city')
                ->all();

        });

        return view('livewire.court-list', [
            'courts' => $courts,
            'cities' => $cities,
        ]);
    }
}