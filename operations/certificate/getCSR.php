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
    $response =  $keyVault->getCSR($name);

    if ($response["responsecode"]==200) {
        var_dump($response);
         $CSR = "-----BEGIN CERTIFICATE REQUEST-----\n" . $response['data']['csr'] . "\n-----END CERTIFICATE REQUEST-----";

         $myfile = fopen("CSRs/".$name.".csr", "w") or die ("Unable to open file!");

         fwrite($myfile, $CSR);

         fclose($myfile);
             
         }

         else {
             var_dump($response["responseMessage"]);
            // return -1;
         }

       
}
?>
