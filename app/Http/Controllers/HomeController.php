<?php

namespace App\Http\Controllers;

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
        $this->middleware("auth");
        $this->middleware("security:auth");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = $request->input("search");
        $query = \App\Models\Product::query();

        if ($search) {
            $query->where("name", "like", "%{$search}%")
                  ->orWhere("description", "like", "%{$search}%");
        }

        $products = $query->latest()->paginate(8);
        return view("home", compact("products", "search"));
    }
}
