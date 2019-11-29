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
class Auth
{
    private $request;
    private $credentials;

    /**
     * Constructor for class
     *
     * @param Signalfire\TrueIdentity\Request     $request     HTTP Client
     * @param Signalfire\TrueIdentity\Credentials $credentials TrueLayer credentials
     */
    public function __construct(Request $request, Credentials $credentials)
    {
        $this->request = $request;
        $this->credentials = $credentials;
    }

    /**
     * Return an access token from TrueLayer
     *
     * @param string $code     Code to exchange for access_token
     * @param string $endpoint API Endpoint
     * @param string $method   Method to use (GET, POST etc)
     * @param string $scope    API request scope
     * @param string $grant    API grant type
     *
     * @return array
     */
    public function getAccessToken(
        $code,
        $redirect,
        $endpoint = '/connect/token',
        $method = 'POST',
        $grant = 'authorization_code'
    ) : array {
        return $this->request->makeRequest(
            $endpoint,
            $method,
            [
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
                'form_params' => [
                    'client_id' => $this->credentials->getClientId(),
                    'client_secret' => $this->credentials->getClientSecret(),
                    'code' => $code,
                    'redirect_uri' => $redirect,
                    'grant_type' => $grant
                ]
            ]
        );
    }

    /**
     * Refreshes a stale access token
     *
     * @param string $token    Token to refresh
     * @param string $endpoint API Endpoint
     * @param string $method   Method to use (GET, POST etc)
     * @param string $grant    API grant type
     *
     * @return array
     */
    public function getRefreshedAccessToken(
        $token,
        $endpoint = '/connect/token',
        $method = 'POST',
        $grant = 'refresh_token'
    ) : array {
        return $this->request->makeRequest(
            $endpoint,
            $method,
            [
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
                'form_params' => [
                    'grant_type' => $grant,
                    'client_id' => $this->credentials->getClientId(),
                    'client_secret' => $this->credentials->getClientSecret(),
                    'refresh_token' => $token
                ]
            ]
        );
    }
}
