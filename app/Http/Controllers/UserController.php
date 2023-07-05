<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // For Get All Data
    public function getData()
    {
        $response = [
            'all users' =>  User::all()
        ];
        return $response;
    }
    // For showing registration Form
    public function register(Request $req)
    {
        $fields = $req->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $req['name'],
            'email' => $req['email'],
            'password' => bcrypt($req['password']),
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }

    //get One Data
    public function getUser($id)
    {
        return User::find($id);
        // return User::where('name', $name)->get();
    }

    //Update data
    public function updateUser(Request $req, $id)
    {
        $fields = $req->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $userFields = [
            'name' => $req['name'],
            'email' => $req['email'],
            'password' => bcrypt($req['password']),
        ];
        $user = User::find($id);
        $user->update($userFields);
        return $user;
    }

    //for delete data
    public function destroy($id)
    {
        return User::destroy($id);
    }


    //user login
    public function login(Request $req)
    {
        $fields = $req->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        //check email 
        $user = User::where('email', $req->email)->get()->first();

        // check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'massage' => 'Bad Cred',
            ]);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return $response;
    }

    //user Logout
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged Out'
        ];
    }

    //for testing purpose
    function test(){
        echo 'ok';
    }
}
