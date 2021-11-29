<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LauanaOH\Dracma\Facades\Dracma;

class ConvertController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(Dracma::convertMany($request->all()));
    }
}
