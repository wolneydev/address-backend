<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\SubwayRequest;
use App\Services\SubwayService;
use App\Traits\ApiResponseTrait;

class SubwayController extends Controller
{
    use ApiResponseTrait;
    protected $subwayService;
    protected $responseClass;

    public function __construct(SubwayService $subwayService)
    {
        $this->subwayService = $subwayService;
    }
    public function index(Request $request)
    {
        try {
            $data = $this->subwayService->index($request);
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
            $data = $this->subwayService->show($token);
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
            $data = $this->subwayService->store($request);
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
            $data = $this->subwayService->update($request, $token);

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
            $result = $this->subwayService->destroy($token);

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
