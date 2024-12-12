<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $req)
    {
        $match = User::orderBy('created_at', 'desc')->where('role', 'business');

        $q = $req->query('q');

        if ($q) $match->where('businessName', 'like', "%$q%")
            ->orWhere('email', 'like', "%$q%");

        $businesses = $match->paginate();

        return view('businesses.page', compact('businesses'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'phone' => 'required|string',
            'address' => 'required|string',
            'businessName' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $alreadyEmail = User::where('email', $req->email)->first();

        if ($alreadyEmail) {
            return response()->json('El correo electrónico proporcionado ya está en uso.', 400);
        }

        $user = new User();
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->role = 'business';
        $user->businessName = $req->businessName;
        $user->email = $req->email;
        $user->password = bcrypt($req->password);
        $user->save();

        return response()->json('Empresa creada correctamente');
    }

    public function update(Request $req, $id)
    {
        $user = User::find($id);


        $req->validate([
            'phone' => 'required|string',
            'address' => 'required|string',
            'businessName' => 'required|string',
            'email' => 'required|email',
        ]);

        $alreadyEmail = User::where('email', $req->email)->where('id', '!=', $user->id)->first();

        if ($alreadyEmail) {
            return response()->json('El correo electrónico proporcionado ya está en uso.', 400);
        }

        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->businessName = $req->businessName;
        $user->email = $req->email;
        $user->save();

        return response()->json('Empresa actualizado correctamente');
    }
    public function toggleStatus($id)
    {
        $user = User::find($id);
        $user->status = !$user->status;
        $user->save();

        $responseText = $user->status ? 'Empresa activado correctamente' : 'Empresa desactivado correctamente';
        return response()->json($responseText);
    }

    public function resetPassword(Request $req, $id)
    {

        $randomPassword = substr(str_shuffle('aR0b3SZ45cefVWXghij78NOPKLMklmnopDEqrCFs12tuvTUYwxyzABGdHIJQ69'), 0, 8);

        $user = User::find($id);
        $user->password = bcrypt($randomPassword);
        $user->save();

        return response()->json('Contraseña restablecida: ' . $randomPassword);
    }
}
