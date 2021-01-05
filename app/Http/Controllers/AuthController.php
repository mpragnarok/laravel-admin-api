<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return \response(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }
        /**
         * @var User $user
         */
        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24);

        return response([
            'jwt' => $token
        ])->withCookie($cookie);
    }

    public function user(Request $request)
    {
        return $request->user();
    }


    public function logout()
    {
        // Instead of making sure I remember to add my $cookie object to the response, I instead use the #queue method to avoid it all together.
        \Cookie::queue(\Cookie::forget('jwt'));
        return response([
            'message' => 'success',
        ]);
    }
}
