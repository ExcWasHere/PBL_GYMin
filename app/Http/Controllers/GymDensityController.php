<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class GymDensityController extends Controller
{
    private int $maxCapacity = 80;

    public function index()
    {
        return view('components.dashboard.gym-density', [
            'maxCapacity' => $this->maxCapacity,
            ...$this->buildDensityData(),
        ]);
    }

    public function live(): JsonResponse
    {
        return response()->json($this->buildDensityData());
    }

    private function buildDensityData(): array
    {
        $now  = Carbon::now();
        $time = $now->format('H:i');
        $activeVisitors = Reservation::where('session_date', today())
            ->where('status', 'confirmed')
            ->where('session_start', '<=', $time)
            ->where('session_end',   '>', $time)
            ->count();

        return [
            'activeVisitors' => $activeVisitors,
            'hourlyStats'    => $this->getHourlyStats(),
            'quietHours'     => $this->getQuietHours(),
            'peakHours'      => $this->getPeakHours(),
            'lastUpdated'    => $now->format('H:i:s'),
        ];
    }

    private function getHourlyStats(): array
    {
        $counts = Reservation::where('session_date', today())
            ->where('status', 'confirmed')
            ->selectRaw('session_start, COUNT(*) as count')
            ->groupBy('session_start')
            ->pluck('count', 'session_start')
            ->toArray();

        $slots = [];
        for ($h = 5; $h <= 22; $h++) {
            $key     = sprintf('%02d:00', $h);
            $slots[] = [
                'hour'  => $key,
                'count' => (int) ($counts[$key] ?? 0),
            ];
        }

        return $slots;
    }

    private function getQuietHours(): string
    {
        $counts = Reservation::where('session_date', today())
            ->where('status', 'confirmed')
            ->selectRaw('session_start, COUNT(*) as count')
            ->groupBy('session_start')
            ->pluck('count', 'session_start')
            ->toArray();

        $threshold = $this->maxCapacity * 0.3;

        $quiet = collect($counts)
            ->filter(fn($c) => $c < $threshold)
            ->keys()
            ->sort()
            ->values();

        if ($quiet->isEmpty()) return 'Belum ada data cukup';

        return $quiet->first() . ' – ' . $quiet->last();
    }

    private function getPeakHours(): string
    {
        $counts = Reservation::where('session_date', today())
            ->where('status', 'confirmed')
            ->selectRaw('session_start, COUNT(*) as count')
            ->groupBy('session_start')
            ->orderByDesc('count')
            ->pluck('count', 'session_start')
            ->toArray();

        if (empty($counts)) return 'Belum ada data cukup';

        $threshold = $this->maxCapacity * 0.6;

        $peak = collect($counts)
            ->filter(fn($c) => $c >= $threshold)
            ->keys()
            ->sort()
            ->values();

        if ($peak->isEmpty()) {
            $top = array_key_first($counts);
            return "{$top} (tersibuk hari ini)";
        }

        return $peak->first() . ' – ' . $peak->last();
    }
}