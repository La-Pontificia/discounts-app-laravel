<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\History;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $authUser = User::find(Auth::id());
        $discounts = [];


        if ($authUser->role === 'business') {
            $discounts = Discount::where('userId', Auth::id())->get();
        } else {
            $discounts = Discount::all();
        }

        $now = date('Y-m-d');

        $query = History::where('created_at', '>=', $now . ' 00:00:00')
            ->orderBy('created_at', 'desc');

        if ($authUser->role === 'business') {
            $query->where('userId', Auth::id());
        }

        $nowHistories = $query->get();

        return view('page', compact('discounts', 'nowHistories'));
    }
}
