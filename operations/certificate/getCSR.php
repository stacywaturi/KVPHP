<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/15
 * Time: 15:28
 */

require '../../vendor/autoload.php';

use azure\keyvault\Certificate as keyVaultCert;
use azure\authorisation\Token as azureAuthorisation;
use azure\Config;

$keyVault = new keyVaultCert(
    [
        'accessToken'  => azureAuthorisation::getKeyVaultToken(
            [
                'appTenantDomainName'   => Config::$APP_TENANT_ID,
                'clientId'              => Config::$CLIENT_ID,
                'username'              => Config::$USERNAME,
                'password'              => Config::$PASSWORD
            ]
        ),
        'keyVaultName' => Config::$KEY_VAULT_NAME
    ]
);

//GET CSR
var_dump($keyVault->getCSR('cert22112'));