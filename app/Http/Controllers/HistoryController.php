<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function export(Request $req)
    {
        $user = User::find(Auth::id());
        $startDate = $req->query('startDate');
        $endDate = $req->query('endDate');
        $businessId = $req->query('businessId');
        $query = History::query()->orderBy('created_at', 'desc');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($user->role === 'business') {
            $query->where('userId', $user->id);
        }

        if ($businessId) {
            $query->where('userId', $businessId);
        }

        // Cargar la plantilla de Excel
        $spreadsheet = IOFactory::load(public_path('template_histories.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        $r = 4;

        $histories = $query->get();

        foreach ($histories as $history) {
            $worksheet->setCellValue('B' . $r, $r + 1);
            $worksheet->setCellValue('C' . $r, $history->client->documentId);
            $worksheet->setCellValue('D' . $r, $history->client->lastNames . ', ' . $history->client->firstNames);
            $worksheet->setCellValue('E' . $r, $history->client->displayType());
            $worksheet->setCellValue('F' . $r, $history->client->businessUnit);
            $worksheet->setCellValue('G' . $r, $history->user->businessName);
            $worksheet->setCellValue('H' . $r, $history->amount . ' %');
            $worksheet->setCellValue('I' . $r, $history->created_at->format('d/m/Y'));
            $worksheet->getStyle('I' . $r)->getNumberFormat()->setFormatCode('DD/MM/YYYY');
            $worksheet->setCellValue('J' . $r, $history->created_at->format('H:i:s'));
            $worksheet->getStyle('J' . $r)->getNumberFormat()->setFormatCode('HH:MM:SS');
            $worksheet->setCellValue('k' . $r, $history->creator ? $history->creator->displayName() : 'N/A');
            $r++;
        }

        foreach (range('B', 'K') as $columnID) {
            $worksheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $fileName =  'histories_' . now()->timestamp . '.xlsx';
        $filePath = 'files/reports/' . $fileName;
        $storagePath = storage_path('app/' . $filePath);

        $directory = dirname($storagePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($storagePath);

        return response()->json([
            'filename' => $fileName
        ]);
    }
}
