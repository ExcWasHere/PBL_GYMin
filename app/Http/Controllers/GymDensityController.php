<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class GymDensityController extends Controller
{
    private int $maxCapacity = 80;
    public function index()
    {
        return view('dashboard.gym-density', [
            'activeVisitors' => 47,
            'maxCapacity'    => $this->maxCapacity,
            'hourlyStats'    => $this->getHourlyStats(),
            'zones'          => $this->getZoneStats(),
            'quietHours'     => '06:00-08:00 & 13:00-15:00',
            'peakHours'      => '17:00-19:00 setiap hari kerja',
        ]);
    }

    private function getHourlyStats(): array
    {
        return [
            ['hour' => '05:00', 'count' => 5],
            ['hour' => '06:00', 'count' => 12],
            ['hour' => '07:00', 'count' => 20],
            ['hour' => '08:00', 'count' => 48],
            ['hour' => '09:00', 'count' => 38],
            ['hour' => '10:00', 'count' => 36],
            ['hour' => '11:00', 'count' => 30],
            ['hour' => '12:00', 'count' => 64],
            ['hour' => '13:00', 'count' => 40],
            ['hour' => '14:00', 'count' => 35],
            ['hour' => '15:00', 'count' => 44],
            ['hour' => '16:00', 'count' => 58],
            ['hour' => '17:00', 'count' => 72],
            ['hour' => '18:00', 'count' => 59],
            ['hour' => '19:00', 'count' => 45],
            ['hour' => '20:00', 'count' => 24],
            ['hour' => '21:00', 'count' => 10],
            ['hour' => '22:00', 'count' => 3],
        ];
    }

    private function getZoneStats(): array
    {
        return [
            ['name' => 'Cardio',      'current' => 18, 'max' => 25],
            ['name' => 'Free Weight', 'current' => 12, 'max' => 20],
            ['name' => 'Mesin',       'current' => 11, 'max' => 15],
            ['name' => 'Loker',       'current' => 6,  'max' => 20],
        ];
    }
}