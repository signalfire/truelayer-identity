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
class AuthLink
{
    private $credentials;
    private $redirectUri;
    private $state;
    private $enableMock;

    /**
     * Constructor for class
     *
     * @param Signalfire\TrueIdentity\Credentials $credentials Credentials for accessing TrueLayer
     * @param string                              $redirectUri URI to redirect to from auth
     * @param string                              $state       Opaque value
     * @param bool                                $enableMock  Enable mock bank
     */
    public function __construct($credentials, $redirectUri, $state, $enableMock)
    {
        $this->credentials = $credentials;
        $this->redirectUri = $redirectUri;
        $this->state = $state;
        $this->enableMock = $enableMock;
    }

    /**
     * Get authorisation link
     *
     * @return string
     */
    public function getAuthLinkUri()
    {
        $params = [
            'client_id' => $this->credentials->getClientId(),
            'redirect_uri' => $this->redirectUri,
            'state' => $this->state,
            'response_mode' => 'form_post',
            'enable_mock' => $this->enableMock ? 'true' : 'false',
            'response_type' => 'code',
            'scope' => 'info',
            'nonce' => $this->getNonce()
        ];

        return sprintf('%s?%s', $this->getTrueLayerUri(), http_build_query($params));
    }

    /**
     * Get the URI to use for request based on if the mock bank is enabled
     *
     * @return string
     */
    protected function getTrueLayerUri()
    {
        return $this->enableMock ? 'https://auth.truelayer-sandbox.com' : 'https://auth.truelayer.com';
    }

    /**
     * Get a random string for nonce
     *
     * @return string
     */
    protected function getNonce()
    {
        return bin2hex(random_bytes(12));
    }
}
