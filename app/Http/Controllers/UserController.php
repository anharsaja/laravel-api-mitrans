<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');  // Pastikan hanya user yang bisa akses
    }

    public function index()
    {
        return response()->json(['message' => 'User Access'], 200);
    }
}
