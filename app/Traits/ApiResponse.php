<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait ApiResponse
{
    public function successResponse($data, $message, $status = Response::HTTP_OK): JsonResponse
    {
        if ($data instanceof JsonResource && isset($data?->response()?->getData()->links))
        {
            $data = [
                'data' => $data,
                'links' => $data->response()->getData()->links,
                'meta' => $data->response()->getData()->meta,
            ];
        }

        $response = ['status' => $status, 'data' => $data, 'message' => $message];

        return response()->json($response, $status);
    }

    public function errorResponse($message, $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $response = ['status' => $status, 'message' => $message];

        return response()->json($response, $status);
    }

    public function excelResponse($writer): StreamedResponse
    {
        return response()->streamDownload(function () use ($writer) {$writer->close();},
            $writer->getPath());
    }
}
