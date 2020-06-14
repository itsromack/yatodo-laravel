<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\User;

class NetworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all()
    {
        return response()->json([
            'success' => true,
            'network' => User::all()
        ]);
    }

    public function friends()
    {
        $user = User::find(Auth::id());
        return response()->json([
            'success' => true,
            'network' => $user->friends()
        ]);
    }
}
