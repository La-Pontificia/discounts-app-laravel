<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\History;
use App\Models\User;
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


        $discount = Discount::find($req->discountId);

        $history = new History();
        $history->clientId = $req->clientId;
        $history->userId =  $discount->userId;
        $history->amount = $discount->amount;
        $history->creatorId = Auth::id();
        $history->save();

        return response()->json('Descuento registrado correctamente');
    }

    public function datesGrouped(Request $req)
    {
        $user = User::find(Auth::id());
        $startDate = $req->query('startDate');
        $endDate = $req->query('endDate');

        $query = History::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        );

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($user->role === 'business') {
            $query->where('userId', $user->id);
        }

        $data = $query
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

    public function perBusinessData(Request $req)
    {
        $user = User::find(Auth::id());
        $startDate = $req->query('startDate');
        $endDate = $req->query('endDate');

        $query = History::select(
            'users.businessName as businessName',
            DB::raw('COUNT(histories.id) as count')
        )
            ->join('users', 'histories.userId', '=', 'users.id');

        if ($startDate) {
            $query->whereDate('histories.created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('histories.created_at', '<=', $endDate);
        }

        if ($user->role === 'business') {
            $query->where('histories.userId', $user->id);
        }


        $data = $query
            ->groupBy('users.businessName')
            ->orderByDesc('count')
            ->get();

        return response()->json($data);
    }

    public function getBusinessHistoryTimeSeries(Request $req)
    {
        $user = User::find(Auth::id());
        $startDate = $req->query('startDate');
        $endDate = $req->query('endDate');

        $query = History::select(
            'users.businessName as businessName',
            DB::raw("DATE_FORMAT(histories.created_at, '%Y-%m-%d') as date"),
            DB::raw('COUNT(histories.id) as count')
        )
            ->join('users', 'histories.userId', '=', 'users.id');

        if ($startDate) {
            $query->whereDate('histories.created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('histories.created_at', '<=', $endDate);
        }

        if ($user->role === 'business') {
            $query->where('histories.userId', $user->id);
        }

        $data = $query
            ->groupBy('users.businessName', 'date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json($data);
    }
}
