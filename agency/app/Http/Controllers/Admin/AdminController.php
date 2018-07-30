<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth.admin:admin');
    }

    public function index()
    {
//        $admin = Auth::guard('admin')->user();
//        return $admin->name;
        return view('admin/index');
    }
}
