<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $cars = Vehicle::where('category_id', 1)->count();
        $motorscycles = Vehicle::where('category_id', 2)->count();


        $widget = [
            'users' => $users,
            'cars' => $cars,
            'motorscycles' => $motorscycles,
            //...
        ];

        return view('home', compact('widget'));
    }
}
