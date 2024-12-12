<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $query = History::orderBy('created_at', 'desc')->limit(10);

        if ($user->role === 'business') {
            $query->where('userId', $user->id);
        }

        $histories = $query->get();

        return view('dashboard.page', compact('histories'));
    }
}
