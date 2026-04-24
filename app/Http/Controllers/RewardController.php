<?php

namespace App\Http\Controllers;

use App\Models\Reward;

class RewardController extends Controller
{
    public function index()
    {
        $userPoints = 1200;
        $userStreak = 7;

        $rewards = Reward::where('is_active', true)->orderByDesc('is_featured')->get();
        $redemptionHistory = collect(); // blom ada tabel redemptions

        return view('components.streak.reward', compact(
            'userPoints',
            'userStreak',
            'rewards',
            'redemptionHistory'
        ));
    }

    public function redeem($id)
    {
        $userPoints = 1200;
        $reward = Reward::findOrFail($id);

        if ($userPoints < $reward->point_cost) {
            return redirect()->back()->with('error', 'Poin kamu tidak cukup');
        }

        $remainingPoints = $userPoints - $reward->point_cost;

        return redirect()->back()->with('success',
            "Berhasil menukar {$reward->name}! Sisa poin: {$remainingPoints}"
        );
    }
}
