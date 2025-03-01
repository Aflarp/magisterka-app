<?php
namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
class AccountController extends Controller
{
    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $user->delete();

        return response()->json(['message' => 'Account deleted successfully']);
    }

}
