<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\PointLog;
use App\Services\StreakService;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function index()
    {
        $user       = Auth::user();
        $rewards    = Reward::where('is_active', true)->orderByDesc('is_featured')->get();

        $redemptionHistory = PointLog::where('user_id', $user->id)
            ->where('type', 'redeem')
            ->with('user')  // jika perlu
            ->latest()
            ->get()
            ->map(function ($log) {
                // Coba ambil nama reward dari description
                $log->reward_name = $log->description;
                $log->points_spent = abs($log->points);
                $log->status = 'success';
                return $log;
            });

        // Point logs untuk history semua tipe
        $pointHistory = PointLog::where('user_id', $user->id)
            ->latest()
            ->take(20)
            ->get();

        return view('components.streak.reward', compact(
            'user',
            'rewards',
            'redemptionHistory',
            'pointHistory',
        ));
    }

    public function redeem($id, StreakService $streakService)
    {
        $user = \App\Models\User::find(Auth::id());
        $reward = Reward::findOrFail($id);

        $success = $streakService->deductPoints(
            $user,
            $reward->point_cost,
            "Penukaran: {$reward->name}"
        );

        if (!$success) {
            return redirect()->back()->with('error', 'Poin kamu tidak cukup untuk menukar hadiah ini.');
        }

        return redirect()->back()->with(
            'success',
            "🎉 Berhasil menukar {$reward->name}! Sisa poin: " . number_format($user->fresh()->points)
        );
    }
}