<?php

namespace App\Http\Controllers;

use App\Models\Rewards;
use Illuminate\Http\Request;

class RewardsController extends Controller
{
    //list all merch
    public function index()
    {
        return view('rewards.index');
    }
}
