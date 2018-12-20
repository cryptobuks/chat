<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        return response()->api($this->user()->friends);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'image' => 'required',
        ]);

        $user = User::firstOrNew($request->only('email'));
        $request->merge(['provider' => 'Google', 'provider_id' => $request->id]);
        $user->fill($request->except('id'))->save();

        return response()->api($user->apiLogin());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $users = User::where(function ($query) use ($request) {
            $query->orWhere('name', 'LIKE', "%{$request->term}%")
                ->orWhere('email', 'LIKE', "%{$request->term}%");
        })->whereNotIn('id', $this->user()->friends()->pluck('id')->merge([$this->user()->id]))
        ->limit(5)->get();

        return response()->api($users);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function invite(Request $request)
    {
        $this->user()->friends()->attach($request->id);

        return response()->api($this->user()->friends);
    }

    /**
     * @return User
     */
    protected function user()
    {
        return auth('api')->user();
    }
}
