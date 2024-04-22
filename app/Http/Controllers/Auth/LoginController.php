<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');

        $dummyData = \App\getDummyUim(['userId' => $username]);

        if ($dummyData['statusCode'] === '200') {
            Session::put([
                'status' => 200,
                'description' => $dummyData['message'],
                'user' => $dummyData['data'],
            ]);
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->with('error', 'Login failed. Please check your credentials.');
        }
    }
}
