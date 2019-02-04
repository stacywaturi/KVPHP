<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/15
 * Time: 15:32
 */

require '../../vendor/autoload.php';

use azure\keyvault\Certificate as keyVaultCert;
use azure\authorisation\Token as azureAuthorisation;
use azure\Config;

session_start();

if($_SESSION['user']){
}
else{
    header("location:index.php");
}

if($_SERVER['REQUEST_METHOD'] = "POST"){

    $name = $_POST['name'];
    $filename = $_POST['filename'];
    $keyVault = new keyVaultCert(
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

   
    $mergeCertResponse = $keyVault->merge($name,$filename);

    if($mergeCertResponse["responsecode"]==201)
    {
        var_dump($mergeCertResponse);
    }
    else
    {
        var_dump($mergeCertResponse["responseMessage"]);
    }
}
