<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/15
 * Time: 15:33
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

    $response = $keyVault->getCert($name);


    if ($response["responsecode"]==200) {
        var_dump($response["data"]);
        $Cert = "-----BEGIN CERTIFICATE-----\n" . $response['data']['cer'] . "\n-----END CERTIFICATE-----";

        $myfile = fopen("certs/".$name.".crt", "w") or die ("Unable to open file!");

        fwrite($myfile, $Cert);

        fclose($myfile);
    

    }

    else {
        var_dump($response["responseMessage"]);
        //return -1;
    }
}