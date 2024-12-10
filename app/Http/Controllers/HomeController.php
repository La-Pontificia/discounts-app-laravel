<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $authUser = User::find(Auth::id());
        $discounts = [];


        if ($authUser->role == 'business') {
            $discounts = $authUser->discounts;
        } else {
            $discounts = Discount::all();
        }
        return view('page', compact('discounts'));
    }
}
