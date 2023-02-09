<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SidebarController extends Controller
{

    public function topUsers(Request $request)
    {
        $days = 0;

        if ($request->period == 'week') {
            $days = 7;
        } elseif ($request->period == 'month') {
            $days = 30;
        } elseif ($request->period == 'year') {
            $days = 365;
        } elseif ($request->period == 'all') {
            $days = 99999;
        }

        $users = User::whereHas('points', function ($query) use ($days) {
            $query->whereDate('created_at', '>=', Carbon::today()->subDay($days));
        })->get();

        foreach ($users as $key => $user) {
            $points = $user->points->where('created_at', '>=', Carbon::today()->subDay($days));
            $sum = 0;
            foreach ($points as $point) {
                $sum += $point->value;
            }
            $user->pointsc = $sum;
            if ($sum <= 0) {
                $users->forget($key);
            }
        }

        $users = $users->sortByDesc('pointsc');
        $users = $users->splice(0, 5);

        return view('user.components.topusers', compact('users'));
    }
}
