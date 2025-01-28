<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // auth controllers
    public function changePassword(Request $req)
    {
        $req->validate([
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string|min:6',
            'confirmPassword' => 'required|string',
        ]);

        if ($req->newPassword !== $req->confirmPassword) {
            return response()->json('Las contraseñas no coinciden', 400);
        }

        $user = User::find(Auth::id());

        if (!password_verify($req->oldPassword, $user->password)) {
            return response()->json('La contraseña actual no coincide', 400);
        }

        $user->password = bcrypt($req->newPassword);
        $user->save();

        return response()->json('Contraseña cambiada correctamente');
    }

    // user controllers
    public function index(Request $req)
    {
        $match = User::orderBy('created_at', 'desc')->where('role', '!=', 'business');

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
            'role' => 'required|string',
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
        $user->role = $req->role;
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
            'role' => 'required|string',
            'email' => 'required|email',
        ]);

        $alreadyEmail = User::where('email', $req->email)->where('id', '!=', $user->id)->first();

        if ($alreadyEmail) {
            return response()->json('Ya existe un usuario con el correo electrónico proporcionado', 400);
        }

        $user->firstNames = $req->firstNames;
        $user->lastNames = $req->lastNames;
        $user->role = $req->role;
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

    public function resetPassword(Request $req, $id)
    {

        $randomPassword = substr(str_shuffle('aR0b3SZ45cefVWXghij78NOPKLMklmnopDEqrCFs12tuvTUYwxyzABGdHIJQ69'), 0, 8);

        $user = User::find($id);
        $user->password = bcrypt($randomPassword);
        $user->save();

        return response()->json('Contraseña restablecida: ' . $randomPassword);
    }
}
