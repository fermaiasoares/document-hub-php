<?php
namespace Versatecnologia\DocumentHub\Exception;

use Exception;
use Illuminate\Http\Client\Response;

class ApiGatewayException extends Exception
{
    public $apiStatus;
    public $apiError;
    public $apiTrace;
    public $apiPath;
    public $apiTimestamp;

    public static function fromResponse(Response $response)
    {
        $body = $response->json();

        $exception = new self(
            message: $body['error'] ?? 'Unknown Api Error',
            code: $body['status'] ?? $response->status(),
        );

        $exception->apiStatus = $body['status'] ?? null;
        $exception->apiError = $body['error'] ?? null;
        $exception->apiTrace = $body['trace'] ?? null;
        $exception->apiPath = $body['path'] ?? null;
        $exception->apiTimestamp = $body['timestamp'] ?? null;

        return $exception;
    } 
}