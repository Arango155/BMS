<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::latest()->get() // 🔥 Aseguramos que siempre envía usuarios
        ]);
    }

    public function getUsers()
    {
        return response()->json(['users' => User::latest()->get()]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente.']);
    }
}
