<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\traits\apiResponse;
use App\Http\Requests\V1\LoginRequest;

class AuthenticationController extends Controller
{
    use apiResponse;

    public function loginUser(LoginRequest $request)
    {
        try {
          
            $validatedData = $request->validated();
    
            $user = User::where('email', $validatedData['email'])->first();
    
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return $this->errorResponse('Email & Password do not match our records.', 401);
            }
    
            $user = Auth::user();
    
            $token = $user->createToken('API TOKEN' . $user->email, ['*'], now()->addMonth())->plainTextToken;
    
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $token,
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
          
            return $this->errorResponse($th->getMessage(), 500);
        }
    }
    


    public function logout(Request $request, $userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }
    
        return $user->tokens()->delete()
            ? $this->successResponse('Logout Successful', 200)
            : $this->errorResponse('Logout Failed', 500);
    }

}
