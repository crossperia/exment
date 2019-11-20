<?php

namespace Exceedone\Exment\Tests\Feature;

use Tests\TestCase;
use Exceedone\Exment\Model\ApiClient;
use Exceedone\Exment\Model\Define;
use Exceedone\Exment\Enums\ApiScope;

abstract class ApiTestBase extends TestCase
{
    /**
     * Get Client Id and Secret 
     *
     * @return void
     */
    protected function getClientIdAndSecret(){
        // get client id and secret token
        $client = ApiClient::where('name', Define::API_FEATURE_TEST)->first();

        return [$client->id, $client->secret];
    }

    /**
     * Get Password token
     *
     * @return void
     */
    protected function getPasswordToken($user_code, $password, $scope = []){
        list($client_id, $client_secret) = $this->getClientIdAndSecret();
        
        if(\is_nullorempty($scope)){
            $scope = ApiScope::arrays();
        }

        return $this->post(admin_urls('oauth', 'token'), [
            "grant_type" => "password",
            "client_id" => $client_id,
            "client_secret" =>  $client_secret,
            "username" =>  $user_code,
            "password" =>  $password,
            "scope" =>  implode(' ', $scope),
        ]);
    }

    
    /**
     * Get Admin access token for administrator
     *
     * @return void
     */
    protected function getAdminAccessToken($scope = []){
        $response = $this->getPasswordToken('admin', 'adminadmin', $scope);

        return array_get(json_decode($response->baseResponse->getContent(), true), 'access_token');
    }
}
