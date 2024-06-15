<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:12',
        ]);
        try{
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        
        ]);
        
        $user->save();
        return response()->json([
            'message' => 'Successfully registered',
            'user' => $user,
        ], 201);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangani disini
            return redirect('/register')->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
}
