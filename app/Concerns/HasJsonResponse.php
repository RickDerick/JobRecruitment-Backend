<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasJsonResponse
{
    public function respond($data, $message = '', $code = 200): JsonResponse
    {
        if ($data instanceof \Exception){
            $message = $data->getMessage();
            $code = 500;
        }

        if ($data instanceof Model)
            $data = $this->resource
                ? new $this->resource($data)
                : new JsonResource($data);

        if ($data instanceof Collection)
            $data = $this->resource
                ? $this->resource::collection($data)
                : JsonResource::collection($data);

        if ($code >= 200 && $code <= 299){
            return response()->json([
                'status' => get_http_status($code),
                'data' => $data,
            ], $code);
        }

        if (is_string($data))
            $message = $data;

        return response()->json([
            'status' => get_http_status($code),
            'message' => $message,
        ], $code);
    }
}
