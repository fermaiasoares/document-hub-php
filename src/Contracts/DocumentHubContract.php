<?php

namespace Versatecnologia\DocumentHub\Contracts;

use Versatecnologia\DocumentHub\DTOs\DocumentFile;
use Versatecnologia\DocumentHub\Exception\ApiGatewayException;

interface DocumentHubContract
{
    /**
     * @param string $reportName
     * @return array
     * @throws ApiGatewayException
     */
    public static function getReportParam(string $reportName): array;

    /**
     * @param string $reportName
     * @param string $format ex: 'pdf', 'doc', 'xls'
     * @param array $data
     * @param array $connection
     * @return DocumentFile
     * @throws ApiGatewayException
     */
    public static function generateReport(string $reportName, string $format, array $data, array $connection = []): DocumentFile;

    /**
     * @param string $reportName
     * @param string $format ex: 'pdf', 'doc', 'xls'
     * @param array $data
     * @param array $connection
     * @return DocumentFile
     * @throws ApiGatewayException
     */
    public static function generateReportAsync(string $reportName, string $format, array $data, array $connection = []): array;

    /**
     * @param array $data
     * @return array
     * @throws ApiGatewayException
     */
    public static function getJobStatus(string $jobId): array;
}
