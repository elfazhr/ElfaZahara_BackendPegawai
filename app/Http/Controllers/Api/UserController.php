<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'messages' => 'Please Complete Your Data',
                ], 400);
            }

            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'messages' => 'Email or Password Incorrect',
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => true,
                'messages' => 'Login Berhasil',
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user
                ],
            ]);

        } catch (Exception $error) {
            return response()->json([
                'status' => false,
                'messages' => 'There is an error',
                'error' => $error->getMessage()
            ], 500);
        }
    }
    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();
        return [
            'status' => true,
            'messages' => 'Logout Success',
        ];
    }

    public function index()
    {
        $data = Auth::user();

        return response()->json([
            'status' => true,
            'messages' => 'Data User berhasil diambil',
            'data' => $data,
        ]);
    }

    public function register(Request $request)
    {
        $data = new User;

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'messages' => 'Failed to add data',
                'data' => $validator->errors()
            ]);
        }
        $data->email = $request->email;
        $data->password = Hash::make($request->input('password'));

        $post = $data->save();

        return response()->json([
            'status' => true,
            'messages' => 'Success to add data',
            'data' => $data,
        ]);

    }

    public function update(Request $request, string $id)
{
    // Periksa input
    // dd($request->all()); // Debugging: ini akan menampilkan semua input yang dikirim ke fungsi ini

    $data = User::find($id);
    if (empty($data)) {
        return response()->json([
            'status' => false,
            'messages' => 'Failed to find data'
        ], 404);
    }

    $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'messages' => 'Failed to update data',
            'data' => $validator->errors()
        ]);
    }

    $data->email = $request->email;
    $data->password = Hash::make($request->input('password'));
    $data->save();

    return response()->json([
        'status' => true,
        'messages' => 'Success to update data',
    ]);
}


    public function destroy(string $id)
    {
        $data = User::find($id);

        if (empty($data)) {
            return response()->json([
                'status' => false,
                'messages' => 'Data Gagal Ditemukan'
            ], 404);
        }

        $post = $data->delete();

        return response()->json([
            'status' => true,
            'messages' => 'Berhasil Melakukan Delete Data',
        ]);
    }
}
