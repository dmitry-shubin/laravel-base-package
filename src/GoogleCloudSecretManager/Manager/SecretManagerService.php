<?php

namespace Inventcorp\LaravelBasePackage\GoogleCloudSecretManager\Manager;

use Google\ApiCore\ApiException;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\SecretManager\V1\Replication;
use Google\Cloud\SecretManager\V1\Replication\Automatic;
use Google\Cloud\SecretManager\V1\Secret;
use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;
use Google\Cloud\SecretManager\V1\SecretPayload;
use Google\Cloud\SecretManager\V1\SecretVersion;
use InvalidArgumentException;
use Inventcorp\LaravelBasePackage\Helpers\AppHelper;

class SecretManagerService
{
    private SecretManagerServiceClient $client;

    public function __construct(SecretManagerServiceClient $client)
    {
        $this->client = $client;
    }

    private function getProjectName(): string
    {
        return SecretManagerServiceClient::projectName(AppHelper::getProjectId());
    }

    private function getClient(): SecretManagerServiceClient
    {
        return $this->client;
    }

    private function createSecret(string $secretId): string
    {
        return $this->getClient()
            ->createSecret(
                $this->getProjectName(),
                $secretId,
                new Secret(['replication' => new Replication(['automatic' => new Automatic()])])
            )
            ->getName();
    }

    /**
     * @param string $secretId
     * @return void
     * @throws ApiException
     * @throws NotFoundException
     */
    public function deleteSecret(string $secretId): void
    {
        try {
            $this->getClient()->deleteSecret($secretId);
        } catch (ApiException $exception) {
            if ($exception->getStatus() === 'NOT_FOUND' && $exception->getCode() === 5) {
                throw new NotFoundException(
                    "Secret '$secretId' is not found",
                    $exception->getCode(),
                    $exception,
                    $exception->getTrace()
                );
            }
            throw $exception;
        }
    }

    /**
     * @param string $secretId
     * @param SecretPayload $payload
     * @return SecretVersion
     * @throws ApiException
     */
    private function addSecretVersion(string $secretId, SecretPayload $payload): SecretVersion
    {
        return $this->getClient()->addSecretVersion($secretId, $payload);
    }

    /**
     * @param string $secretId
     * @param string $payload
     * @return string Secret id
     * @throws ApiException
     */
    public function addSecretValue(string $secretId, string $payload): string
    {
        if (empty($payload)) {
            throw new InvalidArgumentException('Payload is empty');
        }

        $payload = new SecretPayload(['data' => $payload]);

        try {
            return  $this->addSecretVersion($secretId, $payload)->getName();
        } catch (ApiException $exception) {
            if ($exception->getStatus() === 'NOT_FOUND' && $exception->getCode() === 5) {
                $this->createSecret($secretId);
                return $this->addSecretVersion($secretId, $payload)->getName();
            }

            throw $exception;
        }
    }

    /**
     * @param string $secretId
     * @param string $version
     * @return string
     * @throws ApiException
     */
    public function getSecretValue(string $secretId, string $version = 'latest'): string
    {
        $name = $this->getClient()
            ->secretVersionName(
                AppHelper::getProjectId(),
                $secretId,
                $version
            );

        return $this->getClient()
            ->accessSecretVersion($name)
            ->getPayload()
            ->getData();
    }
}
