<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\TestClass; // Załaduj klasę TestClass

class UserController extends Controller
{

    

    public function edit(Request $request, $id)
    {
        if (!$request->user()->tokenCan('edit')) {
            return response()->json(['message' => 'Brak uprawnień do edytowania danych.'], 403);
        }

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user);
    }

    public function view(Request $request, $id)
    {
        if (!$request->user()->tokenCan('view')) {
            return response()->json(['message' => 'Brak uprawnień do przeglądania danych.'], 403);
        }

        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function getUserWithSQLI(Request $request)
    {
        $name = $request->input('name');
        $query = "SELECT * FROM users WHERE name = '$name'";
        $user = DB::select($query);

        return response()->json($user);
    }

    public function getUserWithoutSQLI(Request $request) 
    {
        $name = $request->input('name');
        $user = User::where('name', $name)->first();

        return response()->json($user);
    }

    public function IncorrectloginWithRedirect(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $redirectTo = $request->input('redirect_to', 'https://www.ur.edu.pl/pl/strona-glowna');

            return redirect($redirectTo);
        }

        return back()->withErrors(['email' => 'Nieprawidłowe dane logowania.']);
    }

    public function CorrectloginWithRedirect(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $redirectTo = $request->input('redirect_to', 'https://www.ur.edu.pl/pl/strona-glowna');

            if (!str_starts_with($redirectTo, '/') || str_contains($redirectTo, '://')) {
                $redirectTo = 'https://www.ur.edu.pl/pl/strona-glowna';
            }

            return redirect($redirectTo);
        }

        return back()->withErrors(['email' => 'Nieprawidłowe dane logowania.']);
    }
}




