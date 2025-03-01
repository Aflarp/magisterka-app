<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function delete(Request $request, $id)
    {
        $data = serialize([
            'username' => 'admin',
            'role' => 'administrator'
        ]);
        DB::table('users')->insert(['data' => $data]);

        $input = DB::table('users')->where('id', $id)->value('data');
        $user = unserialize($input);
        echo "Witaj, {$user['username']}!";

    }


    public function getUser(Request $request)
    {
        $username = $request->input('username');
        $query = "SELECT * FROM users WHERE username = '$username'";
        $user = DB::select($query);

        return response()->json($user);
    }


    public function loginWithRedirect(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $redirectTo = $request->input('redirect_to', '/dashboard');

            if (!str_starts_with($redirectTo, '/') || str_contains($redirectTo, '://')) {
                $redirectTo = '/dashboard';
            }

            return redirect($redirectTo);
        }

        return back()->withErrors(['email' => 'Nieprawidłowe dane logowania.']);
    }
}




