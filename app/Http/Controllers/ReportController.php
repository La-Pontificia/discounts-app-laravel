<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $req)
    {
        $q = $req->query('q');
        $startDate = $req->query('startDate');
        $endDate = $req->query('endDate');
        $match = History::orderBy('created_at', 'desc');

        if ($q) {
            $match->whereHas('client', function ($query) use ($q) {
                $query->where('firstNames', 'like', "%$q%")
                    ->orWhere('lastNames', 'like', "%$q%")
                    ->orWhere('documentId', 'like', "%$q%");
            });
        }

        if ($startDate) {
            $match->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $match->where('created_at', '<=', $endDate);
        }

        $histories = $match->paginate();
        return view('reports.page', compact('histories'));
    }
}
