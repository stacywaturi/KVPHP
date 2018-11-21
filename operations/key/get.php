<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/15
 * Time: 15:32
 */

require '../../vendor/autoload.php';

use azure\keyvault\Key as keyVaultKey;
use azure\authorisation\Token as azureAuthorisation;
use azure\Config;

$keyVault = new KeyVaultKey(
    [
        'accessToken'  => azureAuthorisation::getKeyVaultToken(
            [
                'appTenantDomainName'   => Config::$APP_TENANT_ID ,
                'clientId'              => Config::$CLIENT_ID,
                'username'              => Config::$USERNAME,
                'password'              => Config::$PASSWORD
            ]
        ),
        'keyVaultName' => Config::$KEY_VAULT_NAME
    ]
);
$getKeyResponse = $keyVault->get("key1311");

if ($getKeyResponse["responsecode"]==200){
    var_dump($getKeyResponse['data']['key']);
}
else {
    var_dump($getKeyResponse["responseMessage"]);
}