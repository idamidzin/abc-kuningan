<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Booking;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
    	$produk = [];
    	$booking = [];
    	$user = [];
        return view('dashboard', compact('produk','booking','user'));
    }
}
