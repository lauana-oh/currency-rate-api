<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvertRequest;
use Illuminate\Http\JsonResponse;
use LauanaOH\Dracma\Facades\Dracma;

class ConvertController extends Controller
{
    public function __invoke(ConvertRequest $request): JsonResponse
    {
        return response()->json(Dracma::convertMany($request->validated()));
    }
}
