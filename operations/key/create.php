<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/13
 * Time: 09:47
 */

require '../../vendor/autoload.php';

use azure\keyvault\Key as keyVaultKey;
use azure\authorisation\Token as azureAuthorisation;
use azure\Config;

session_start();

if($_SESSION['user']){
}
else{
    header("location:index.php");
}

if($_SERVER['REQUEST_METHOD'] = "POST"){

    $name    = $_POST['name'];
    $keyType = $_POST['keyType'];
    $keySize = $_POST['keySize'];

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

    //var_dump($keyVault->create('key1311','RSA','2048'));
    $createKeyResponse = $keyVault->create($name,$keyType,$keySize);
    if ($createKeyResponse["responsecode"]==200){
        var_dump($createKeyResponse['data']['key']);
    }
    else {
        var_dump($createKeyResponse["responseMessage"]);
    }
}