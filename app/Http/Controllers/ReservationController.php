<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservationController extends Controller
{
    const SESSIONS = [
        ['start' => '06:00', 'end' => '08:00'],
        ['start' => '08:00', 'end' => '10:00'],
        ['start' => '10:00', 'end' => '12:00'],
        ['start' => '12:00', 'end' => '14:00'],
        ['start' => '14:00', 'end' => '16:00'],
        ['start' => '16:00', 'end' => '18:00'],
        ['start' => '18:00', 'end' => '20:00'],
        ['start' => '20:00', 'end' => '22:00'],
    ];
    const MAX_CAPACITY = 20;
    public function index()
    {
        $activeTicket = [
            'code'          => 'GYM-' . today()->format('Ymd') . '-' . strtoupper(Str::random(4)),
            'session_date'  => today()->toDateString(),
            'session_start' => '08:00',
            'session_end'   => '10:00',
            'status'        => 'pending',
        ];

        $history = [
            ['session_date' => today()->subDays(1)->toDateString(), 'session_start' => '06:00', 'session_end' => '08:00', 'status' => 'confirmed'],
            ['session_date' => today()->subDays(4)->toDateString(), 'session_start' => '10:00', 'session_end' => '12:00', 'status' => 'done'],
            ['session_date' => today()->subDays(8)->toDateString(), 'session_start' => '16:00', 'session_end' => '18:00', 'status' => 'done'],
            ['session_date' => today()->subDays(11)->toDateString(),'session_start' => '18:00', 'session_end' => '20:00', 'status' => 'done'],
        ];

        $slotAvailability = $this->getDummySlotAvailability();

        $messages = [
            ['sender_id' => 0,         'message' => 'Halo kak! Ada yang bisa dibantu terkait reservasi? 💪', 'created_at' => now()->subMinutes(30)],
            ['sender_id' => Auth::id(), 'message' => 'Halo min, slot sesi sore masih ada ga?',               'created_at' => now()->subMinutes(28)],
            ['sender_id' => 0,         'message' => 'Masih ada kak! Sesi 16:00–18:00 tinggal 4 slot.',       'created_at' => now()->subMinutes(27)],
        ];

        return view('components.reservation.reservasi', compact(
            'activeTicket',
            'history',
            'slotAvailability',
            'messages'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'session_date'  => ['required', 'date', 'after_or_equal:today'],
            'session_start' => ['required', 'date_format:H:i'],
            'session_end'   => ['required', 'date_format:H:i', 'after:session_start'],
            'notes'         => ['nullable', 'string', 'max:500'],
        ]);
        $code = 'GYM-'
            . Carbon::parse($request->session_date)->format('Ymd')
            . '-'
            . strtoupper(Str::random(4));

        return redirect()->route('reservasi')
            ->with('success', "Reservasi berhasil! Kode kamu: {$code}");
    }

    public function destroy($id)
    {
        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }

    public function slots(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
        ]);
        return response()->json($this->getDummySlotAvailability());
    }

    public function sendChat(Request $request)
    {
        $request->validate([
            'message'     => ['required', 'string', 'max:1000'],
            'receiver_id' => ['required', 'integer'],
        ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'sender_id'   => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'message'     => $request->message,
                'created_at'  => now()->toDateTimeString(),
            ],
        ]);
    }

    public function getChat(Request $request)
    {
        $request->validate([
            'receiver_id' => ['required', 'integer'],
        ]);

        $messages = [
            ['sender_id' => 0,                'message' => 'Halo kak! Ada yang bisa dibantu? 💪',     'created_at' => now()->subMinutes(30)->toDateTimeString()],
            ['sender_id' => Auth::id(),        'message' => 'Halo min, slot sesi sore masih ada ga?', 'created_at' => now()->subMinutes(28)->toDateTimeString()],
            ['sender_id' => 0,                'message' => 'Masih ada kak! Tinggal 4 slot.',          'created_at' => now()->subMinutes(27)->toDateTimeString()],
        ];

        return response()->json(['success' => true, 'data' => $messages]);
    }

    private function getDummySlotAvailability(): array
    {
        $dummyTaken = [
            '10:00' => 20,
            '14:00' => 15,
            '18:00' => 8,
        ];

        return collect(self::SESSIONS)->map(function ($slot) use ($dummyTaken) {
            $taken = $dummyTaken[$slot['start']] ?? rand(0, 10);
            return [
                'start'     => $slot['start'],
                'end'       => $slot['end'],
                'taken'     => $taken,
                'available' => self::MAX_CAPACITY - $taken,
                'is_full'   => $taken >= self::MAX_CAPACITY,
            ];
        })->toArray();
    }
}