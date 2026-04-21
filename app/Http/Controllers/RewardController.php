<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RewardController extends Controller
{
    public function index()
    {
        // 🔥 Dummy user data
        $userPoints = 1200;
        $userStreak = 7;

        // 🎁 Dummy rewards
        $rewards = collect([
            (object)[
                'id' => 1,
                'name' => 'Whey Protein 1kg',
                'description' => 'Suplemen protein untuk recovery otot',
                'point_cost' => 800,
                'category' => 'suplemen',
                'image' => null,
                'is_featured' => true
            ],
            (object)[
                'id' => 2,
                'name' => 'Gym Gloves',
                'description' => 'Sarung tangan gym anti slip',
                'point_cost' => 400,
                'category' => 'aksesoris',
                'image' => null,
                'is_featured' => false
            ],
            (object)[
                'id' => 3,
                'name' => 'Diskon Membership 50%',
                'description' => 'Potongan harga membership gym',
                'point_cost' => 1000,
                'category' => 'diskon',
                'image' => null,
                'is_featured' => true
            ],
            (object)[
                'id' => 4,
                'name' => 'Gym T-Shirt Exclusive',
                'description' => 'Merchandise official gym',
                'point_cost' => 600,
                'category' => 'merchandise',
                'image' => null,
                'is_featured' => false
            ],
        ]);

        // 📜 Dummy history
        $redemptionHistory = collect([
            (object)[
                'reward' => (object)['name' => 'Gym Gloves'],
                'points_spent' => 400,
                'created_at' => now()->subDays(2),
                'status' => 'success'
            ],
            (object)[
                'reward' => (object)['name' => 'T-Shirt'],
                'points_spent' => 600,
                'created_at' => now()->subDays(5),
                'status' => 'pending'
            ],
        ]);

        return view('components.streak.reward', compact(
            'userPoints',
            'userStreak',
            'rewards',
            'redemptionHistory'
        ));
    }

    public function redeem($id)
    {
        // 🔥 Dummy user points
        $userPoints = 1200;

        // 🎁 Dummy rewards (HARUS sama kayak index biar konsisten)
        $rewards = collect([
            (object)['id'=>1,'name'=>'Whey Protein 1kg','point_cost'=>800],
            (object)['id'=>2,'name'=>'Gym Gloves','point_cost'=>400],
            (object)['id'=>3,'name'=>'Diskon Membership 50%','point_cost'=>1000],
            (object)['id'=>4,'name'=>'Gym T-Shirt Exclusive','point_cost'=>600],
        ]);

        $reward = $rewards->firstWhere('id', $id);

        if (!$reward) {
            return redirect()->back()->with('error', 'Reward tidak ditemukan');
        }

        if ($userPoints < $reward->point_cost) {
            return redirect()->back()->with('error', 'Poin kamu tidak cukup');
        }

        // 💡 Simulasi potong poin (dummy)
        $remainingPoints = $userPoints - $reward->point_cost;

        return redirect()->back()->with('success', 
            "Berhasil menukar {$reward->name}! Sisa poin: {$remainingPoints}"
        );
    }
}