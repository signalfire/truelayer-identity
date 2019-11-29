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
class Credentials
{
    private $clientId;
    private $clientSecret;
    private $code;

    /**
     * Constructor
     *
     * @param string $clientId     TrueLayer Client ID
     * @param string $clientSecret TrueLayer Client Secret
     */
    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Property getter for clientId
     *
     * @return string
     */
    public function getClientId() : string
    {
        return $this->clientId;
    }

    /**
     * Property getter for clientSecret
     *
     * @return string
     */
    public function getClientSecret() : string
    {
        return $this->clientSecret;
    }
}
