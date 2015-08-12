<?php
session_start();
include "config/connect.php";

function LDAP_auth($PHP_AUTH_USER1,$PHP_AUTH_PW1){          
   $auth=0;
   global $nama;
   //$ldapconfig['host'] = 'merahputih.telkom.co.id';
   $ldapconfig['host'] = '10.0.32.230';
   $ldapconfig['authrealm'] = 'User Intranet Telkom ND';
   if ($PHP_AUTH_USER1 != "" && $PHP_AUTH_PW1 != "") {
        $ds=@ldap_connect($ldapconfig['host']);
        $r = @ldap_search( $ds, " ", 'uid=' . $PHP_AUTH_USER1);
        if ($r) {
            $result = @ldap_get_entries( $ds, $r);
            if (isset($result[0])) {
                if (@ldap_bind( $ds, $result[0]['dn'], $PHP_AUTH_PW1) ) {
          $auth=1;
                }
            }
        }
    }
   return $auth; 
}
$portal_auth=0;
$portal_auth_d=0;

$username=$_POST['username'];
$password=$_POST['password'];
$nextpage="index.php";

/*if(isset( $username ) && isset( $password )){
    $portal_auth_d=LDAP_auth($username,$password );
}*/

if ($portal_auth_d!=1) { 
     $cek=OCIParse($connect, "SELECT * FROM SB_LOGIN WHERE NIK='$username' AND PASSWORD='$password'");
     OCIExecute($cek);
     $hasil=OCI_Fetch_array($cek);
      
     if (!empty($hasil[0]))
     {
        $_SESSION['username'] = $username;
        $_SESSION['realname'] = $hasil[1];
        $_SESSION['privilege'] = $hasil[5];
        header("location:".$nextpage);
     }
     else
     {
      header("location:failed.php");
     }
}
else
{
     $cek=OCIParse($connect, "SELECT * FROM SB_LOGIN WHERE NIK='$username'");
     OCIExecute($cek);
     $hasil=OCI_Fetch_array($cek);
      
     if (!empty($hasil[0]))
     {
        $_SESSION['username'] = $username;
        $_SESSION['realname'] = $hasil[1];
        $_SESSION['privilege'] = $hasil[5];
        header("location:".$nextpage);
     }
     else
     {
        $_SESSION['username'] = $username;
        $_SESSION['realname'] = $username;
        $_SESSION['privilege'] = "guest";
        header("location:".$nextpage);
     }
}
?>