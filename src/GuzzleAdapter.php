<?php

namespace Solarium\Core\Client\Adapter;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Solarium\Core\Configurable;
use Solarium\Core\Client\Request;
use Solarium\Core\Client\Response;
use Solarium\Core\Client\Endpoint;
use Solarium\Exception\HttpException;

/**
 * Guzzle HTTP adapter.
 */
class GuzzleAdapter extends Configurable implements AdapterInterface
{
    /**
     * The Guzzle HTTP client instance.
     *
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * Execute a Solr request using the cURL Http.
     *
     * @param Request  $request  The incoming Solr request.
     * @param Endpoint $endpoint The configured Solr endpoint.
     *
     * @return Response
     *
     * @throws HttpException Thrown if solr request connot be made.
     * @codingStandardsIgnoreStart Interface does not declare type-hints
     */
    public function execute($request, $endpoint)
    {
        //@codingStandardsIgnoreEnd
        $requestOptions = [
            RequestOptions::HEADERS => $this->getRequestHeaders($request),
            RequestOptions::BODY => $this->getRequestBody($request),
            RequestOptions::TIMEOUT => $endpoint->getTimeout(),
        ];

        // Try endpoint authentication first, fallback to request for backwards compatibility
        $authData = $endpoint->getAuthentication();
        if (empty($authData['username'])) {
            $authData = $request->getAuthentication();
        }

        if (!empty($authData['username']) && !empty($authData['password'])) {
            $requestOptions[RequestOptions::AUTH] = [$authData['username'], $authData['password']];
        }

        try {
            $guzzleResponse = $this->getGuzzleClient()->request(
                $request->getMethod(),
                $endpoint->getBaseUri() . $request->getUri(),
                $requestOptions
            );

            $responseHeaders = [
                "HTTP/{$guzzleResponse->getProtocolVersion()} {$guzzleResponse->getStatusCode()} "
                . $guzzleResponse->getReasonPhrase(),
            ];

            foreach ($guzzleResponse->getHeaders() as $key => $value) {
                $responseHeaders[] = "{$key}: " . implode(', ', $value);
            }

            return new Response((string)$guzzleResponse->getBody(), $responseHeaders);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $error = $e->getMessage();
            throw new HttpException("HTTP request failed, {$error}");
        }
    }

    /**
     * Gets the Guzzle HTTP client instance.
     *
     * @return GuzzleClient
     */
    public function getGuzzleClient()
    {
        if ($this->guzzleClient === null) {
            $this->guzzleClient = new GuzzleClient($this->options);
        }

        return $this->guzzleClient;
    }

    /**
     * Helper method to create a request body suitable for a guzzle 3 request.
     *
     * @param Request $request The incoming solarium request.
     *
     * @return null|resource|string
     */
    private function getRequestBody(Request $request)
    {
        if ($request->getMethod() !== Request::METHOD_POST) {
            return null;
        }

        if ($request->getFileUpload()) {
            return fopen($request->getFileUpload(), 'r');
        }

        return $request->getRawData();
    }

    /**
     * Helper method to extract headers from the incoming solarium request and put them in a format
     * suitable for a guzzle 3 request.
     *
     * @param Request $request The incoming solarium request.
     *
     * @return array
     */
    private function getRequestHeaders(Request $request)
    {
        $headers = [];
        foreach ($request->getHeaders() as $headerLine) {
            list($header, $value) = explode(':', $headerLine);
            if ($header = trim($header)) {
                $headers[$header] = trim($value);
            }
        }

        if (!isset($headers['Content-Type'])) {
            if ($request->getMethod() == Request::METHOD_GET) {
                $headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=utf-8';
            } else {
                $headers['Content-Type'] = 'application/xml; charset=utf-8';
            }
        }

        return $headers;
    }
}
