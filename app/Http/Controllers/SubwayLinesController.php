<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\SubwayLinesRequest;
use App\Services\SubwayLinesService;
use App\Traits\ApiResponseTrait;

class SubwayLinesController extends Controller
{
    use ApiResponseTrait;
    protected $subway_linesService;
    protected $responseClass;

    public function __construct(SubwayLinesService $subway_linesService)
    {
        $this->subway_linesService = $subway_linesService;
    }
    public function index(Request $request)
    {
        try {
            $data = $this->subway_linesService->index($request);
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
            $data = $this->subway_linesService->show($token);
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
            $data = $this->subway_linesService->store($request);
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
            $data = $this->subway_linesService->update($request, $token);

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
            $result = $this->subway_linesService->destroy($token);

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
