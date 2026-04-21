<?php

namespace App\Http\Controllers;

use App\Models\ProgressLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        /** @var User $user */

        $user = Auth::user();
        $logs = $user->progressLogs()->orderBy('log_date', 'asc')->get();

        return view('components.dashboard.progress', compact('logs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'log_date' => 'required|date',
            'weight_kg' => 'nullable|numeric|min:1|max:300',
            'muscle_mass_kg' => 'nullable|numeric|min:1|max:200',
            'body_fat_pct' => 'nullable|numeric|min:0|max:100',
            'workout_notes' => 'nullable|string|max:1000',
        ]);

        /** @var User $user */

        $user = Auth::user();
        $user->progressLogs()->updateOrCreate(['log_date' => $data['log_date']],$data);

        return back()->with('success', 'progress berhasil disimpan!');
    }

    public function destroy(ProgressLog $progressLog)
    {
        abort_if($progressLog->user_id !== Auth::id(), 403);
        $progressLog->delete();
        return back()->with('success', 'log dihapus.');
    }
}
