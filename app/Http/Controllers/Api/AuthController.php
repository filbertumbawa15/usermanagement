<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'EMAIL WAJIB DIISI',
            'password.required' => 'PASSWORD WAJIB DIISI',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // $token = $this->generateToken($user);
            return response([
                'user' => $user,
                'access_token' => Auth::user()->createToken('accessToken')->accessToken,
            ]);
        } else {
            return response([
                'message' => "User Not Found",
            ], 404);
        }
    }

    public function generateToken(User $user)
    {
        $payload = [
            'sub' => $user->id,
            'iat' => 1356999524,
            'nbf' => 1357000000
        ];

        $token = JWT::encode($payload, env('JWT_KEY'), env('JWT_ALG'));

        return $token;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
