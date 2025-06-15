<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query', '');
        
        $results = User::where('username', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get(['id', 'username']);
        
        return response()->json($results);
    }
}
