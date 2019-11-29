<?php
/**
 * PHP TrueIdentity Package
 *
 * @copyright 2019 Robert Coster
 * @link      https://github.com/signalfire
 */

namespace Signalfire\TrueIdentity;

/**
 * @package TrueIdentity
 * @author  Robert Coster <rob@signalfire.co.uk>
 * @since   1.0.0
 */
class Info
{
    private $request;
    private $token;

    /**
     * Constructor for class
     *
     * @param Signalfire\TrueIdentity\Request $request HTTP Client
     * @param string                          $token   Token to use for request
     */
    public function __construct(Request $request, string $token)
    {
        $this->request = $request;
        $this->token = $token;
    }

    public function getInfo(
        $endpoint = '/data/v1/info',
        $method = 'GET'
    ) : array {
        return $this->request->makeRequest(
            $endpoint,
            $method,
            [
                'headers' => ['Authorization' => sprintf('Bearer %s', $this->token)],
            ]
        );
    }
}
