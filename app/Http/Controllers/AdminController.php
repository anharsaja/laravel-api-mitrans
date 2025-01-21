<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');  // Pastikan hanya admin yang bisa akses
    }

    public function index()
    {
        return response()->json(['message' => 'Admin Access'], 200);
    }
}
