<?php

namespace App\Services;

use App\Models\PointLog;
use App\Models\User;
use Carbon\Carbon;

class StreakService
{
    /**
     * Milestone streak → bonus poin ekstra.
     * Key = hari ke-N, Value = bonus poin
     */
    const STREAK_MILESTONES = [
        3  => 50,
        7  => 150,
        14 => 300,
        30 => 750,
        60 => 1500,
        90 => 3000,
    ];

    /**
     * Poin dasar per login harian.
     * Meningkat seiring streak.
     */
    const BASE_POINTS      = 10;
    const STREAK_BONUS_PER = 2;   // tambahan poin per hari streak
    const STREAK_CAP_DAYS  = 30;  // cap bonus streak di hari ke-30

    /**
     * Proses streak login. Dipanggil setelah user berhasil login.
     * Return array info untuk ditampilkan di popup.
     */
    public function processLogin(User $user): array
    {
        $today     = Carbon::today();
        $lastLogin = $user->last_login_date ? Carbon::parse($user->last_login_date) : null;

        // Sudah login hari ini → skip (tidak dobel poin)
        if ($lastLogin && $lastLogin->isSameDay($today)) {
            return ['already_claimed' => true];
        }

        $prevStreak = $user->streak_days;
        $isNewStreak = false;

        // Tentukan apakah streak lanjut atau reset
        if ($lastLogin && $lastLogin->isSameDay($today->copy()->subDay())) {
            // Login berturut-turut → streak naik
            $newStreak = $prevStreak + 1;
        } else {
            // Lewat sehari atau pertama kali → streak reset ke 1
            $newStreak   = 1;
            $isNewStreak = $prevStreak > 0; // tandai reset (bukan pertama kali)
        }

        // Hitung poin yang didapat
        $streakBonus   = min($newStreak - 1, self::STREAK_CAP_DAYS) * self::STREAK_BONUS_PER;
        $pointsEarned  = self::BASE_POINTS + $streakBonus;

        // Cek milestone streak
        $milestoneBonus       = 0;
        $milestoneDescription = null;
        if (isset(self::STREAK_MILESTONES[$newStreak])) {
            $milestoneBonus       = self::STREAK_MILESTONES[$newStreak];
            $milestoneDescription = "Bonus milestone streak {$newStreak} hari! 🔥";
        }

        $totalPoints = $pointsEarned + $milestoneBonus;

        // Update user
        $user->points         += $totalPoints;
        $user->streak_days     = $newStreak;
        $user->longest_streak  = max($user->longest_streak, $newStreak);
        $user->last_login_date = $today;
        $user->total_logins   += 1;
        $user->save();

        // Catat ke point_logs
        PointLog::create([
            'user_id'     => $user->id,
            'points'      => $pointsEarned,
            'type'        => 'login',
            'description' => "Login harian (streak {$newStreak} hari)",
        ]);

        if ($milestoneBonus > 0) {
            PointLog::create([
                'user_id'     => $user->id,
                'points'      => $milestoneBonus,
                'type'        => 'streak_bonus',
                'description' => $milestoneDescription,
            ]);
        }

        return [
            'already_claimed'      => false,
            'streak'               => $newStreak,
            'prev_streak'          => $prevStreak,
            'is_reset'             => $isNewStreak && $newStreak === 1,
            'points_earned'        => $pointsEarned,
            'milestone_bonus'      => $milestoneBonus,
            'total_points_earned'  => $totalPoints,
            'total_points'         => $user->points,
            'is_milestone'         => $milestoneBonus > 0,
            'milestone_description'=> $milestoneDescription,
            'next_milestone'       => $this->getNextMilestone($newStreak),
        ];
    }

    /**
     * Kurangi poin user saat redeem reward.
     */
    public function deductPoints(User $user, int $amount, string $description): bool
    {
        if ($user->points < $amount) {
            return false;
        }

        $user->decrement('points', $amount);

        PointLog::create([
            'user_id'     => $user->id,
            'points'      => -$amount,
            'type'        => 'redeem',
            'description' => $description,
        ]);

        return true;
    }

    private function getNextMilestone(int $currentStreak): ?array
    {
        foreach (self::STREAK_MILESTONES as $day => $bonus) {
            if ($day > $currentStreak) {
                return ['day' => $day, 'bonus' => $bonus, 'remaining' => $day - $currentStreak];
            }
        }
        return null;
    }
}