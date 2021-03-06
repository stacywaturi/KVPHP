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

session_start();

if($_SESSION['user']){
}
else{
    header("location:index.php");
}

if($_SERVER['REQUEST_METHOD'] = "POST"){

    // $name = $_POST['name'];

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

    $getKeyResponse = $keyVault->listKeys();

   
    if ($getKeyResponse["responsecode"] == 200) {
        foreach ($getKeyResponse["data"]["value"] as $key) {
           var_dump($key);
           echo "<br><br>";
        }
       
    }
    else {
        var_dump($getKeyResponse["responseMessage"]);
    }
}