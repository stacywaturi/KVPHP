<?php
/**
     * Created by PhpStorm.
     * User: stacy
     * Date: 2018/11/15
     * Time: 15:24
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
        $subject = $_POST['subject'];
     
       
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
        //"CREATE CERT"
        $created = $keyVault->create($name,'CN='.$subject);
        var_dump($created);
        // print_r($created['responseMessage']['code']."\n\n"); 
        // Print $created['responseMessage']['message'];
        //var_dump($created);
     //   var_dump($keyVault->create('cert22112','CN=cert22112'));
        
    }
    ?>
    


  

   