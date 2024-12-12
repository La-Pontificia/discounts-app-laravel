<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function datesGrouped()
    {
        $data = History::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'x' => $item->date,
                    'y' => $item->count
                ];
            });

        return response()->json($data);
    }

    public function perBusinessData()
    {
        $data = History::select(
            'users.businessName as businessName',
            DB::raw('COUNT(histories.id) as count')
        )
            ->join('discounts', 'histories.discountId', '=', 'discounts.id')
            ->join('users', 'discounts.userId', '=', 'users.id')
            ->groupBy('users.businessName')
            ->orderByDesc('count')
            ->get();

        return response()->json($data);
    }

    public function getBusinessHistoryTimeSeries()
    {
        $data = History::select(
            'users.businessName as businessName',
            DB::raw("DATE_FORMAT(histories.created_at, '%Y-%m-%d') as date"),
            DB::raw('COUNT(histories.id) as count')
        )
            ->join('discounts', 'histories.discountId', '=', 'discounts.id')
            ->join('users', 'discounts.userId', '=', 'users.id')
            ->groupBy('users.businessName', 'date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json($data);
    }
}
