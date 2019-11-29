<?php
/**
 * PHP TrueIdentity Package
 *
 * @copyright 2019 Robert Coster
 * @link      https://github.com/signalfire
 */

namespace Signalfire\TrueIdentity;

use GuzzleHttp\Client;

/**
 * @package TrueIdentity
 * @author  Robert Coster <rob@signalfire.co.uk>
 * @since   1.0.0
 */
class Request extends Client
{
    /**
     * Make remote HTTP request
     *
     * @param string $endpoint Endpoint for request
     * @param string $method   Method (GET, POST) to use for request
     * @param array  $data     Data to send (header, body etc)
     *
     * @return array
     */
    public function makeRequest(
        string $endpoint,
        string $method,
        array $data = []
    ) : array {
        try {
            $response = $this->request($method, $endpoint, $data);
            return [
                'statusCode' => $response->getStatusCode(),
                'reason' => $response->getReasonPhrase(),
                'body' => json_decode($response->getBody(), true)
            ];
        } catch (\Exception $ex) {
            return [
                'error' => true,
                'reason' => $ex->getMessage()
            ];
        }
    }
}
