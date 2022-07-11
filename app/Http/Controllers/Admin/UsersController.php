<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('admin.user.index', compact('users'));
    }

    public function detail($id)
    {
        $user =  User::where('id', $id)->first();
        return view('admin.user.detail', compact('user'));
    }
}
