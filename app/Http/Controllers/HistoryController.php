<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function store(Request $req)
    {
        $req->validate([
            'clientId' => 'required',
            'discountId' => 'required',
        ]);

        $history = new History();
        $history->clientId = $req->clientId;
        $history->discountId = $req->discountId;
        $history->userId = Auth::id();
        $history->save();

        return response()->json('Descuento registrado correctamente');
    }
}
