<?php


namespace Vanguardkras;

use Google_Client;
use Google_Service_Oauth2;

class SimpleGoogleAuth
{
    /**
     * Google_Client instance.
     *
     * @var Google_Client
     */
    protected $client;

    /**
     * Default retreiving data
     *
     * @var array
     */
    protected $defaultScopes = ['email', 'profile'];

    /**
     * Default outcome fields.
     *
     * @var array
     */
    protected $fields = [
        'email',
        'familyName',
        'gender',
        'givenName',
        'name',
        'picture',
    ];

    /**
     * SimpleGoogleAuth constructor.
     *
     * @param string $configPath Path to client_secret.json file.
     * @throws \Google_Exception
     */
    public function __construct(string $configPath)
    {
        $this->client = new Google_client();
        $this->client->setAuthConfig($configPath);
        $this->client->setScopes($this->defaultScopes);
    }

    /**
     * Get google login link.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Retrieve profile info. You can use this function without any conditions,
     * as in case of lack of code parameter it will return false;
     *
     * @param bool $object Put false to return an array instead of stdClass
     * @return array|bool|\stdClass
     */
    public function getProfileInfo($object = true)
    {
        if (isset($_GET['code'])) {

            $data = $this->retrieveUserInfo();

            if ($object) {
                $result = new \stdClass;
                foreach ($this->fields as $field) {
                    $result->$field = $data->$field;
                }
            } else {
                $result = [];
                foreach ($this->fields as $field) {
                    $result[$field] = $data->$field;
                }
            }

            return $result;

        } else {
            return false;
        }
    }

    /**
     * Service function for retreiving an access token and the subsequent
     * information about the registered user.
     *
     * @return \Google_Service_Oauth2_Userinfoplus
     */
    protected function retrieveUserInfo()
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
        $this->client->setAccessToken($token['access_token']);

        $profile = new Google_Service_Oauth2($this->client);
        return $profile->userinfo->get();
    }
}