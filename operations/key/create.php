<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/13
 * Time: 09:47
 */

require '../../vendor/autoload.php';

include_once '../../src/db/Database.php';

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

    $user_id = $_SESSION['user_id'];
    $vault_id = $_SESSION['vault_id'];

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

    $createKeyResponse = $keyVault->create($name,$keyType,$keySize);

    if ($createKeyResponse["responsecode"]==200) {

        //Extract the modulus "n" of the public key 
        $key_data = $createKeyResponse['data']['key']['n'];

        // var_dump($createKeyResponse['data']['key']['n']);
        // var_dump($user_id);
        // var_dump($vault_id);

        Print "\r\n Succesfully created key ".$name."\r\n";
        //Generate a unique random ID for the Keys ID column
        $unique_id = uniqid(rand(),false);

        //Usage is "General" for the "Create Key" request
        $usage = "General";

        /*Insert Key and attributes into Database
        */
        $database = new Database();
        $db = $database->connect();
        
        try {

             $result = $db->query("INSERT INTO `keys`(`id`, `name`, `user_id`, `usage`, `public_key`,`vault_id`) VALUES ('$unique_id','$name','$user_id','$usage', '$key_data','$vault_id')");

        } catch (Exception $e) {
             echo "Exception -> ";
             var_dump($e->getMessage());
        }

    }

  
    else {
        
        var_dump($createKeyResponse["responseMessage"]);
}


}