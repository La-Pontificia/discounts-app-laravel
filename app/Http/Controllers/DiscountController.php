<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    public function index(Request $req)
    {

        $authUser = User::find(Auth::id());

        $users = [];

        if ($authUser->role == 'business') {
            $users = User::where('id', $authUser->id)->get()->where('role', 'business');
        } else {
            $users = User::where('role', 'business')->get();
        }

        $match = Discount::orderBy('created_at', 'desc');

        $q = $req->query('q');

        if ($q) $match->whereHas('user', function ($query) use ($q) {
            $query->where('businessName', 'like', "%$q%")
                ->orWhere('email', 'like', "%$q%")
                ->orWhere('firstNames', 'like', "%$q%")
                ->orWhere('lastNames', 'like', "%$q%");
        });

        $discounts = $match->paginate();

        return view('discounts.page', compact('discounts', 'users'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'userId' => 'required|exists:users,id',
            'amount' => 'required|min:0|max:100|numeric',
        ]);

        $discount = new Discount();
        $discount->userId = $req->userId;
        $discount->amount = $req->amount;
        $discount->creatorId = Auth::id();
        $discount->save();

        return response()->json('Descuento creado correctamente');
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'amount' => 'required|min:0|max:100|numeric',
            'userId' => 'required|exists:users,id',
        ]);

        $discount = Discount::find($id);
        $discount->amount = $req->amount;
        $discount->userId = $req->userId;
        $discount->save();

        return response()->json('Descuento actualizado correctamente');
    }

    public function destroy($id)
    {
        $discount = Discount::find($id);
        $discount->delete();

        return response()->json('Descuento eliminado correctamente');
    }
}
