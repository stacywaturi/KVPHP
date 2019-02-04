<?php
/**
     * Created by PhpStorm.
     * User: stacy
     * Date: 2018/11/15
     * Time: 15:24
     */
    require '../../vendor/autoload.php';

    include_once '../../src/db/Database.php';

    use azure\keyvault\Certificate as keyVaultCert;
    use azure\keyvault\Key as keyVaultKey;
    use azure\authorisation\Token as azureAuthorisation;
    use azure\Config;

    session_start();
    if($_SESSION['user']){
    }
    else{
        header("location:index.php");
    }

    $common_name = "";
    $email       = "";
    $org         = "";
    $org_unit    = "";
    $state       = "";
    $country     = "";

    if($_SERVER['REQUEST_METHOD'] = "POST"){

        $name        =  $_POST['name'];

        //Certificate attributes
        $common_name = 'CN='.$_POST['common_name'];
        $email       = 'E='. $_POST['email'];
        $org         = 'O='. $_POST['organization'];
        $org_unit    = 'OU='.$_POST['organization_unit'];
        $state       = 'S='. $_POST['state'];
        $country     = 'C='. $_POST['country'];
        
        //Key Attributes
        $key_size = $_POST['keySize'];
        $key_type = $_POST['keyType'];

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

        $keyVault2 = new keyVaultKey(
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

        $subject = $common_name.','.$email.','.$org.','.$org_unit.','.$country.','.$state;

        $created = $keyVault->create($name,$subject,$key_type,$key_size);
        
        print_r($created);

        if ($created['responsecode'] == 202)
        {
            $csr = $created['data']['csr'];

            // var_dump($user_id);
            // var_dump($vault_id);
         
            Print "\r\n Succesfully created key ".$name."\r\n";

            //Get created KEY
            $getKeyResponse = $keyVault2->get($name);

            if ($getKeyResponse["responsecode"] == 200) {
                var_dump($getKeyResponse['data']['key']['n']);
                $key_data = $getKeyResponse['data']['key']['n'];
            }
            else {
                var_dump($getKeyResponse["responseMessage"]);
                $key_data = "";

            }

            //Generate a unique random ID for the Keys ID column
            $unique_id_key =uniqid(rand(),false);

            //Usage is "General" for the "Create Key" request
            $usage = "Certificate";

            //User ID
            $user_id = $_SESSION['user_id'];
            //Vault ID
            $vault_id = $_SESSION['vault_id'];
            
            
            /*Insert Key and attributes into Database
            */
            $database = new Database();
            $db = $database->connect();
            
            try {

                 $result = $db->query("INSERT INTO `keys`(`id`, `name`, `user_id`, `usage`, `public_key`,`vault_id`) VALUES ('$unique_id_key','$name','$user_id','$usage', '$key_data','$vault_id')");

            } catch (Exception $e) {
                 echo "Exception -> ";
                 var_dump($e->getMessage());
            }

            //Certificate Attributes to be inserted into the Certificates Table

            //1.id
            $unique_id_cert = uniqid(rand(),false);

            //2. name = $name
            //3. key_id 
            $key_id = $unique_id_key;

            //4. user_id =$user_id;
            //5. csr =$csr 
            //6. certificate = $cert (to be merged)
            //7. previous_id -- if name == table_name then previous_id = $id (same cert), for now 

            //8. created_at = time_stamp
            //9. expiry -- to be updated once cert is merged
            //10. common_name -- to be updated once cert is merged
            //11. serial_number -- to be updated once cert is merged
            //12. issuer -- to be updated once cert is merged

            /*Insert Certificate and attributes into Database
            */
            

            try {

                 $result = $db->query("INSERT INTO `certificates`(`id`, `name`,`key_id`, `user_id`, `csr`) VALUES ('$unique_id_cert','$name','$key_id', '$user_id','$csr')");

            } catch (Exception $e) {
                 echo "Exception->  ";
                 var_dump($e->getMessage());
 
            }
        
        }

        else
        {
            var_dump($created);
        }
    }
    ?>
    


  

   