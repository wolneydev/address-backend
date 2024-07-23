<?php

namespace App\Traits;

use App\Http\Responses\ResponseClass;
use Illuminate\Http\Response;

trait ApiResponseTrait
{
    private function createSuccessResponse($data, $message)
    {
        $totalCount = $data['totalCount'] ?? null;
        return ResponseClass::create()
            ->status('success')
            ->message($message)
            ->data($data)
            ->totalCount($totalCount)
            ->build();
    }

    private function createErrorResponse($errorMessage, $data = null)
    {
        return ResponseClass::create()
            ->status('error')
            ->message($errorMessage)
            ->data($data)
            ->build();
    }

    private function jsonResponse($data, $status = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $status);
    }
}
