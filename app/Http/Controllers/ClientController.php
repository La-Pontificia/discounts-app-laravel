<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ClientController extends Controller
{
    public function index(Request $req)
    {
        $match = Client::orderBy('created_at', 'desc');

        $q = $req->query('q');
        $type = $req->query('type');

        if ($q) $match->where('firstNames', 'like', "%$q%")
            ->orWhere('lastNames', 'like', "%$q%")
            ->orWhere('documentId', 'like', "%$q%");

        if ($type) $match->where('type', $type);

        $clients = $match->paginate();

        return view('clients.page', compact('clients'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'firstNames' => 'required|string',
            'lastNames' => 'required|string',
            'businessUnit' => 'required|string',
            'documentId' => 'required|numeric', // <-- |min:8|max:8 not found
            'type' => 'required|string',
        ]);

        $alreadyDni = Client::where('documentId', $req->dni)->first();
        if ($alreadyDni) return response()->json('El DNI ya se encuentra registrado', 400);

        $client = new Client();
        $client->firstNames = $req->firstNames;
        $client->lastNames = $req->lastNames;
        $client->businessUnit = $req->businessUnit;
        $client->documentId = $req->documentId;
        $client->type = $req->type;
        $client->status = $req->status ? true : false;
        $client->userId = Auth::id();
        $client->save();

        return response()->json('Cliente registrado correctamente');
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'firstNames' => 'required|string',
            'lastNames' => 'required|string',
            'businessUnit' => 'required|string',
            'documentId' => 'required|numeric',
            'type' => 'required|string',
        ]);

        $client = Client::find($id);
        $client->firstNames = $req->firstNames;
        $client->lastNames = $req->lastNames;
        $client->businessUnit = $req->businessUnit;
        $client->documentId = $req->documentId;
        $client->type = $req->type;
        $client->status = $req->status ? true : false;
        $client->save();

        return response()->json('Cliente actualizado correctamente');
    }

    public function toggleStatus($id)
    {
        $client = Client::find($id);
        $client->status = !$client->status;
        $client->save();

        return response()->json('Estado del cliente actualizado correctamente');
    }

    public function delete($id)
    {
        $client = Client::find($id);
        $client->delete();

        return response()->json('Cliente eliminado correctamente');
    }

    public function import(Request $req)
    {
        $req->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $req->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $data = [];
        $validTypes = ['docente', 'alumno', 'directivo', 'ppff'];

        // return shet in array


        foreach ($sheet->getRowIterator(3) as $row) {
            $cellIterator = $row->getCellIterator('B', 'G');
            // $cellIterator->setIterateOnlyExistingCells(false);
            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }



            if (empty($rowData[0])) continue;

            if (
                empty($rowData[0]) || strlen($rowData[0]) !== 8 || !ctype_digit($rowData[0]) ||
                empty($rowData[1]) ||
                empty($rowData[2]) ||
                empty($rowData[3]) ||
                empty($rowData[4]) || !in_array(strtolower($rowData[4]), $validTypes)
            ) {

                return response()->json('El archivo contiene errores en las filas. Verifica que todas las columnas cumplan con las reglas especificadas.', 422);
            }

            $data[] = [
                'documentId' => $rowData[0],
                'lastNames' => $rowData[1],
                'firstNames' => $rowData[2],
                'businessUnit' => $rowData[3],
                'type' => strtolower($rowData[4]),
                'status' => $rowData[5] == '1' ? true : false,
            ];
        }

        $documentIds = array_column($data, 'documentId');
        $existingClients = Client::whereIn('documentId', $documentIds)->get();

        $toUpdate = [];
        $toInsert = [];

        foreach ($data as $clientData) {
            $existingClient = $existingClients->firstWhere('documentId', $clientData['documentId']);
            if ($existingClient) {
                $toUpdate[] = [
                    'id' => $existingClient->id,
                    'lastNames' => $clientData['lastNames'],
                    'firstNames' => $clientData['firstNames'],
                    'businessUnit' => $clientData['businessUnit'],
                    'type' => $clientData['type'],
                    'status' => $clientData['status'],
                    'updated_at' => now(),
                    'updaterId' => Auth::id(),
                ];
            } else {
                $toInsert[] = array_merge($clientData, ['created_at' => now(), 'updated_at' => now(), 'userId' => Auth::id()]);
            }
        }

        foreach ($toUpdate as $update) {
            Client::where('id', $update['id'])->update(Arr::except($update, ['id']));
        }

        if (!empty($toInsert)) {
            Client::insert($toInsert);
        }

        return response()->json('Clientes importados correctamente');
    }

    public function one(Request $req)
    {

        $slug = $req->query('slug');
        $user = Client::where('id', $slug)->orWhere('documentId', $slug)->first();
        if (!$user || !$user->status) return response()->json('Cliente no encontrado', 404);
        return response()->json($user);
    }
}
