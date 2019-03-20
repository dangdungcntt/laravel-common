<?php
/**
 * Created by PhpStorm.
 * User: dangdung
 * Date: 04/03/2019
 * Time: 14:58
 */

namespace Pushtimze\Common\Http\Services;

use Illuminate\Container\Container;
use Illuminate\Log\Logger;
use Nddcoder\HttpClient\HttpClient;

abstract class BaseService
{
    /** @var \Illuminate\Log\Logger */
    protected $logger;
    /**
     * @var \Nddcoder\HttpClient\HttpClient
     */
    protected $httpClient;
    /**
     * @var bool
     */
    protected $autoFillBasicAuth = true;
    /**
     * @var string|null
     */
    protected $basicAuth = null;
    /**
     * @var string
     */
    protected $baseUrl;

    public function __construct()
    {
        $this->httpClient = Container::getInstance()->make(HttpClient::class);
        $this->logger = Container::getInstance()->make(Logger::class);
        $this->baseUrl = $this->getBaseUrl();
        $this->basicAuth = $this->getBasicAuth();
    }

    abstract protected function getBaseUrl();

    protected function getBasicAuth()
    {
        return null;
    }

    protected function request($method, $url, $options = []) {
        if ($this->autoFillBasicAuth) {
            data_fill($options, 'headers.Authorization', 'Basic ' . $this->basicAuth);
        }

        return $this->httpClient->request($method, $url, $options);
    }

    protected function handleResponse($response, $dataKey, $logMessage = '')
    {
        //Max status code success is 226 IM Used, so 250 is enough to validate success
        if (data_get($response, 'status_code') < 200 || data_get($response, 'status_code') >= 250) {
            $errorCode = time();
            $this->logger->debug("[Error code: $errorCode] {$logMessage}", [
                'response' => $response
            ]);

            return [
                'error_code' => $errorCode,
            ];
        }

        return [
            'data' => data_get($response, $dataKey)
        ];
    }
}
