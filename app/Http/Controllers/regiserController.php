<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Container\Attributes\Auth
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\get;

class regiserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    //  public function store(Request $request)
    // {
    //
    //  $request->validate([
    //    'name' => 'required',
    //  'email' => 'required|email|unique:users',
    //'password' => 'required|',
    //]);
    //  try {
    //        $user = new User();
    //        $user->name = $request->name;
    //      $user->email = $request->email;
    //    $user->password = Hash::make($request->password);

    //            $user->save();
    //          return response()->json([
    //            'status' => 201,
    //          'message' => 'user created successfully'
    //    ], 201);
    //    } catch (Exception $e) {
    //      return response()->json([
    //        'status' => 500,
    //      'message' => 'erreur du serveur ' . $e->getMessage()
    //            ], 500);
    //      }
    // }

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|max:8',
                'password' => 'required|min:4',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status_code' => 422,
                    "status_message" => 'Donnée invalide',
                    'data' => null
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();

            return response()->json([
                'status' => 201,
                'status_message' => "Compte utilisateur créer avec succèes",
                'data' => [
                    'token' => $token,
                    'user' => $user,
                ],
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'status_message' => $e->getMessage(),
                'data' => 'Serve error'
            ], 500);
        }
    }
    public function loginned(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], [
            'email.exists' => "Cette addresse n'est associer à aucun compte"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 422,
                "status_message" => $validator->errors(),
                'data' => null
            ], 422);
        }

        try {
            if (Auth::attempt($request->all())) {
                $user = Auth::user();
                $token = $user->createToken("token")->plainTextToken;
                return response()->json([
                    'status' => 200,
                    'status_message' => "Connexion réussis",
                    'data' => [
                        'token' => $token,
                        'user' => $user,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => 401,
                    'status_message' => "mot de passe ou email invalide",
                    'data' => 'SERVER ERROR'
                ], 401);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'status_message' => $e->getMessage(),
                'data' => 'SERVER ERROR'
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        try {
            auth('sanctum')->user()->tokens()->delete();
            return response()->json([
                'status' => 200,
                'status_message' => "Vous ête déconnecter",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'status_message' => $e->getMessage(),
                'data' => 'SERVER ERROR'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'phone' => 'sometimes|min:6',
                'password' => 'sometimes|min:6|confirmed',
            ]);

            if ($request->has('password')) {
                $validated['password'] = bcrypt($request->password);
            }

            $user->update($validated);

            return response()->json([
                'Status_message' => 'Profil mis à jour',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function info()
    {
        return response()->json([
            'status' => 200,
            'status_message' => "user info",
            'data' => auth('sanctum')->user(),
        ], 200);
    }
}
