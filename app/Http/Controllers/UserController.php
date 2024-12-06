<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $req)
    {
        $match = User::orderBy('created_at', 'desc');

        $q = $req->query('q');

        if ($q) $match->where('firstNames', 'like', "%$q%")
            ->orWhere('lastNames', 'like', "%$q%")
            ->orWhere('email', 'like', "%$q%");

        $users = $match->paginate();

        return view('users.page', compact('users'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'firstNames' => 'required|string',
            'lastNames' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'role' => 'required|string',
            'businessName' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $alreadyEmail = User::where('email', $req->email)->first();

        if ($alreadyEmail) {
            return response()->json('Ya existe un usuario con el correo electrónico proporcionado', 400);
        }

        $user = new User();
        $user->firstNames = $req->firstNames;
        $user->lastNames = $req->lastNames;
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->role = $req->role;
        $user->businessName = $req->businessName;
        $user->email = $req->email;
        $user->password = bcrypt($req->password);
        $user->save();

        return response()->json('Usuario creado correctamente');
    }

    public function update(Request $req, $id)
    {
        $user = User::find($id);


        $req->validate([
            'firstNames' => 'required|string',
            'lastNames' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'role' => 'required|string',
            'businessName' => 'required|string',
            'email' => 'required|email',
        ]);

        $alreadyEmail = User::where('email', $req->email)->where('id', '!=', $user->id)->first();

        if ($alreadyEmail) {
            return response()->json('Ya existe un usuario con el correo electrónico proporcionado', 400);
        }

        $user->firstNames = $req->firstNames;
        $user->lastNames = $req->lastNames;
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->role = $req->role;
        $user->businessName = $req->businessName;
        $user->email = $req->email;
        $user->save();

        return response()->json('Usuario actualizado correctamente');
    }
    public function toggleStatus($id)
    {
        $user = User::find($id);
        $user->status = !$user->status;
        $user->save();

        $responseText = $user->status ? 'Usuario activado correctamente' : 'Usuario desactivado correctamente';
        return response()->json($responseText);
    }
}
