<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index(Request $req)
    {
        $match = Client::orderBy('created_at', 'desc');

        $q = $req->query('q');
        $type = $req->query('type');

        if ($q) $match->where('firstNames', 'like', "%$q%")
            ->orWhere('lastNames', 'like', "%$q%")
            ->orWhere('dni', 'like', "%$q%");

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
            'dni' => 'required|numeric', // <-- |min:8|max:8 not found
            'type' => 'required|string',
        ]);

        $alreadyDni = Client::where('dni', $req->dni)->first();
        if ($alreadyDni) return response()->json('El DNI ya se encuentra registrado', 400);

        $client = new Client();
        $client->firstNames = $req->firstNames;
        $client->lastNames = $req->lastNames;
        $client->businessUnit = $req->businessUnit;
        $client->dni = $req->dni;
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
            'dni' => 'required|numeric',
            'type' => 'required|string',
        ]);

        $client = Client::find($id);
        $client->firstNames = $req->firstNames;
        $client->lastNames = $req->lastNames;
        $client->businessUnit = $req->businessUnit;
        $client->dni = $req->dni;
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
        return response()->json('Clientes importados correctamente');
    }
}
