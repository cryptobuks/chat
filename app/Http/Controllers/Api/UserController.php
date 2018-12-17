<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        // $this->user()->friends();

        return ['status' => true, 'data' => []];
    }

    public function login(Request $request)
    {
        $user = User::firstOrNew($request->only('email'));
        $request->merge(['provider' => 'Google', 'provider_id' => $request->id]);
        $user->fill($request->except('id'))->save();

        return ['status' => true, 'data' => $user->apiLogin()];
    }

    public function search(Request $request)
    {
        $users = User::where(function($query) use ($request) {
            $query->orWhere('name', 'LIKE', "%{$request->term}%")
                ->orWhere('email', 'LIKE', "%{$request->term}%");
        })->limit(5)->get();

        return ['status' => true, 'data' => $users];
    }

    public function invite(Request $request)
    {
        return ['status' => true, 'data' => User::all()];
    }
}
