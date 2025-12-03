<?php

namespace Versatecnologia\DocumentHub;

use Illuminate\Support\Facades\Http;
use Versatecnologia\DocumentHub\Contracts\DocumentHubContract;
use Versatecnologia\DocumentHub\DTOs\DocumentFile;
use Versatecnologia\DocumentHub\Exception\ApiGatewayException;

class DocumentHub implements DocumentHubContract
{
    /**
     * @param string $reportName
     * @return array
     * @throws ApiGatewayException
     */
    public static function getReportParam(string $reportName): array
    {
        $baseUrl = self::baseUrl();

        $response = Http::withToken(self::apiToken())
            ->accept('*/*')
            ->get("$baseUrl/api/report-params", ['reportName' => $reportName]);

        if ($response->failed()) {
            throw ApiGatewayException::fromResponse($response);
        }

        return $response->json();
    }

    /**
     * @param string $reportName
     * @param string $format ex: 'pdf', 'doc', 'xls'
     * @param array $data
     * @param array $connection
     * @return DocumentFile
     * @throws ApiGatewayException
     */
    public static function generateReport(string $reportName, string $format, array $data, array $connection = []): DocumentFile
    {
        $baseUrl = self::baseUrl();

        if (!empty($connection)) {
            $data['connection'] = $connection;
        }

        $response = Http::withToken(self::apiToken())
            ->accept('*/*')
            ->post("$baseUrl/api/generate-report?reportName=$reportName&format=$format", $data);

        if ($response->failed()) {
            throw ApiGatewayException::fromResponse($response);
        }

        return new DocumentFile(
            content: $response->body(),
            contentType: $response->header('Content-Type'),
        );
    }

    /**
     * @param string $reportName
     * @param string $format ex: 'pdf', 'doc', 'xls'
     * @param array $data
     * @param array $connection
     * @return DocumentFile
     * @throws ApiGatewayException
     */
    public static function generateReportAsync(string $reportName, string $format, array $data, array $connection = []): array
    {
        $baseUrl = self::baseUrl();

        if (!empty($connection)) {
            $data['connection'] = $connection;
        }

        $response = Http::withToken(self::apiToken())
            ->accept('*/*')
            ->post("$baseUrl/api/generate-report/queue?reportName=$reportName&format=$format", $data);

        if ($response->failed()) {
            throw ApiGatewayException::fromResponse($response);
        }

        return $response->json();
    }

    /**
     * @param array $data
     * @return array
     * @throws ApiGatewayException
     */
    public static function getJobStatus(string $jobId): array
    {
        $baseUrl = self::baseUrl();

        $response = Http::withToken(self::apiToken())
            ->accept('*/*')
            ->post("$baseUrl/api/get-report-status/$jobId");

        if ($response->failed()) {
            throw ApiGatewayException::fromResponse($response);
        }

        return $response->json();
    }

    protected static function baseUrl(): string
    {
        return config('document-hub.url');
    }

    protected static function apiToken(): string
    {
        return config('document-hub.api-token');
    }
}
