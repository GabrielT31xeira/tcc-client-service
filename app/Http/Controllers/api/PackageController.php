<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageUser;
use Illuminate\Http\JsonResponse;

class PackageController extends Controller
{
    public function index($user_id) : JsonResponse
    {
        try {
            $package = PackageUser::where('user_id', $user_id)->get('package_id');

            return response()->json([
                'packages' => $package
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error has occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create($user_id)
    {
        try {

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error has occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
