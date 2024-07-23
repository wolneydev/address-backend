<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\CarroRequest;
use App\Services\CarroService;
use App\Traits\ApiResponseTrait;

class CarroController extends Controller
{
    use ApiResponseTrait;
    protected $carroService;
    protected $responseClass;

    public function __construct(CarroService $carroService)
    {
        $this->carroService = $carroService;
    }
    public function index(Request $request)
    {
        try {
            $data = $this->carroService->index($request);
            $response = $this->createSuccessResponse($data ?? null, 'Resources retrieved successfully');
            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            $errorResponse = $this->createErrorResponse($e->getMessage(), []);
            return response()->json($errorResponse, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($token)
    {
        try {
            $data = $this->carroService->show($token);
            $response = $this->createSuccessResponse($data ?? null, 'Resource retrieved successfully');
            if (!$data) {
                return response()->json($response, Response::HTTP_NOT_FOUND);
            }
            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            $errorResponse = $this->createErrorResponse($e->getMessage(), null);

            return response()->json($errorResponse, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function store(Request $request)
    {
        try {
            $data = $this->carroService->store($request);
            $response = $this->createSuccessResponse($data ?? null, 'Resource created successfully');
            return response()->json($response, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $errorResponse = $this->createErrorResponse($e->getMessage(), null);

            return response()->json([$errorResponse], Response::HTTP_BAD_REQUEST);
        }
    }




    public function update(Request $request, $token)
    {
        try {
            $data = $this->carroService->update($request, $token);

            if (!$data) {
                $errorResponse = $this->createErrorResponse('Resource not found', null);

                return response()->json($errorResponse, Response::HTTP_NOT_FOUND);
            }

            $response = $this->createSuccessResponse($data ?? null, 'Resource updated successfully');

            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            $errorResponse = $this->createErrorResponse($e->getMessage(), null);

            return response()->json($errorResponse, Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($token)
    {
        try {
            $result = $this->carroService->destroy($token);

            $response = $this->createSuccessResponse($result ?? null, 'Resource deleted successfully');

            if (!$result) {
                return response()->json( $response, Response::HTTP_NOT_FOUND);
            }

            return response()->json($response, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            $errorResponse = $this->createErrorResponse($e->getMessage(), null);

            return response()->json($errorResponse, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
