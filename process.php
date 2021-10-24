<?php

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 50000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

session_start();

if($_SERVER['REQUEST_METHOD'] === "POST"){

    function save_img($file, $var_name) {
        $errors = array();
        $file_name = $file['name'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];
        $tmp = explode('.', $file['name']);
        $file_ext = strtolower(end($tmp));
    
        $extensions = array("jpeg", "jpg", 'png');
    
        if(in_array($file_ext, $extensions) === false){
            $errors[] = "";
            return false;
        }
    
        if($file_size > 5097152){
            $errors[] = "";
            return false;
        }
    
        if(empty($errors) == true){
            $images_dir = 'img/tmp';
            if(file_exists("$images_dir/$file_name"))
                unlink("$images_dir/$file_name");
            move_uploaded_file($file_tmp, "$images_dir/$file_name");
            $_SESSION[$var_name] = "$images_dir/$file_name";
            return true;
        }
        return false;
    }

    if(isset($_POST["page"])){
        switch ($_POST['page']) {
            case 1:
                if(!isset($_POST['full_name']) || !isset($_POST['phone']) || !isset($_POST['email']) || !isset($_POST['sirket']) || !isset($_POST['tcvkn']) || !isset($_POST['il']) || !isset($_POST['ilce']) || !isset($_POST['kategori'])) {
                    echo 0;
                    exit();
                }
                if(!isset($_FILES['kimlikOn']) || !isset($_FILES['kimlikArka']) || !isset($_FILES['ikametgah'])){
                    echo 2;
                    exit();
                }

                $_SESSION['full_name'] = $_POST['full_name'];
                $_SESSION['phone'] = $_POST['phone'];
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['sirket'] = $_POST['sirket'];
                $_SESSION['tcvkn'] = $_POST['tcvkn'];
                $_SESSION['il'] = $_POST['il'];
                $_SESSION['ilce'] = $_POST['ilce'];
                $_SESSION['kategori'] = $_POST['kategori'];

                if(!save_img($_FILES['kimlikOn'], 'kimlikOn')){
                    echo 6;
                    exit();
                }
                if(!save_img($_FILES['kimlikArka'], 'kimlikArka')){
                    echo 7;
                    exit();
                }
                if(!save_img($_FILES['ikametgah'], 'ikametgah')){
                    echo 8;
                    exit();
                }

                echo 1;
                exit();

            case 2:

                if(!isset($_POST['parola']) || !isset($_POST['parola2'])){
                    echo 2;
                    exit();
                }

                if($_POST['parola'] !== $_POST['parola2']){
                    echo 3;
                    exit();
                }

                $_SESSION['parola'] = $_POST['parola'];

                echo 1;
                exit();

            case 3:
                if(!isset($_POST['magazaAdi']) || !isset($_POST['kep']) || !isset($_POST['mersis']) || !isset($_POST['fatura']) || !isset($_POST['iban'])){
                    echo 0;
                    exit();
                }
                if(!isset($_FILES['vergiLevhe']) || !isset($_FILES['imza'])){
                    echo 2;
                    exit();
                }

                if(isset($_FILES['gazete'])) {
                    if(!save_img($_FILES['gazete'], 'gazete')){
                        echo 8;
                        exit();
                    }
                }
                if(isset($_FILES['belge'])) {
                    if(!save_img($_FILES['belge'], 'belge')){
                        echo 9;
                        exit();
                    }
                }

                $_SESSION['magazaAdi'] = $_POST['magazaAdi'];
                $_SESSION['kep'] = $_POST['kep'];
                $_SESSION['mersis'] = $_POST['mersis'];
                $_SESSION['fatura'] = $_POST['fatura'];
                $_SESSION['iban'] = $_POST['iban'];

                if(!save_img($_FILES['vergiLevhe'], 'vergiLevhe')){
                    echo 6;
                    exit();
                }
                if(!save_img($_FILES['imza'], 'imza')){
                    echo 7;
                    exit();
                }

                echo 1;
                exit();

            case 4:
                if(!isset($_POST['kargoFirma']) || !isset($_POST['teslimSure']) || !isset($_POST['entegrasyonModel']) || !isset($_POST['faturaAdres']) || !isset($_POST['sirketAdres']) || !isset($_POST['depoAdres']) || !isset($_POST['iadeAdres']) || !isset($_POST['finansName']) || !isset($_POST['finansPhone']) || !isset($_POST['finansEmail']) || !isset($_POST['musteriName']) || !isset($_POST['musteriPhone']) || !isset($_POST['musteriEmail']) || !isset($_POST['operasyonName']) || !isset($_POST['operasyonPhone']) || !isset($_POST['operasyonEmail'])){
                    echo 2;
                    exit();
                }
                
                $_SESSION['kargoFirma'] = $_POST['kargoFirma'];
                $_SESSION['teslimSure'] = $_POST['teslimSure'];
                $_SESSION['entegrasyonModel'] = $_POST['entegrasyonModel'];
                $_SESSION['faturaAdres'] = $_POST['faturaAdres'];
                $_SESSION['sirketAdres'] = $_POST['sirketAdres'];
                $_SESSION['depoAdres'] = $_POST['depoAdres'];
                $_SESSION['iadeAdres'] = $_POST['iadeAdres'];
                $_SESSION['finansName'] = $_POST['finansName'];
                $_SESSION['finansPhone'] = $_POST['finansPhone'];
                $_SESSION['finansEmail'] = $_POST['finansEmail'];
                $_SESSION['musteriName'] = $_POST['musteriName'];
                $_SESSION['musteriPhone'] = $_POST['musteriPhone'];
                $_SESSION['musteriEmail'] = $_POST['musteriEmail'];
                $_SESSION['operasyonName'] = $_POST['operasyonName'];
                $_SESSION['operasyonPhone'] = $_POST['operasyonPhone'];
                $_SESSION['operasyonEmail'] = $_POST['operasyonEmail'];
                
                $fname = array(
                    $_SESSION['kimlikOn'],
                    $_SESSION['kimlikArka'],
                    $_SESSION['ikametgah'],
                    $_SESSION['vergiLevhe'],
                    $_SESSION['imza'],
                ); 

                if ($_SESSION['gazete']) {
                    array_push($fname, $_SESSION['gazete']);
                }

                if ($_SESSION['belge']) {
                    array_push($fname, $_SESSION['belge']);
                }
            
                // array with filenames to be sent as attachment
                $files = $fname;
            
                // email fields: to, from, subject, and so on
                $to = "info@taksepet.com";
                $from = $_SESSION['email']; 
                $subject ="Test with attachments"; 
                $message = "
                    Şirket yetkilisinin adı ve soyadı:\t". $_SESSION['full_name']."\n
                    Şirket yetkilisinin telefon numarası:\t". $_SESSION['phone']."\n
                    Şirket yetkilisinin e-posta adresi:\t". $_SESSION['email']."\n
                    Şirket türü:\t". $_SESSION['sirket']."\n
                    Faaliyet gösterilen il:\t". $_SESSION['il']."\n
                    Faaliyet gösterilen ilçe:\t". $_SESSION['ilce']."\n
                    Satış kategorisi:\t". $_SESSION['kategori']."\n
                    Parolanız:\t". $_SESSION['parola']."\n
                    Mağaza adı:\t". $_SESSION['magazaAdi']."\n
                    KEP Adresi:\t". $_SESSION['kep']."\n
                    MERSİS Numarası:\t". $_SESSION['mersis']."\n
                    Fatura türü:\t". $_SESSION['fatura']."\n
                    Firmanıza ait İBAN numarası:\t". $_SESSION['iban']."\n
                    Çalışılacak kargo firmalarını aralarına virgül koyarak belirtiniz:\t". $_SESSION['kargoFirma']."\n
                    Siparişleri ne kadar sürede kargoya teslim edersiniz:\t". $_SESSION['teslimSure']."\n
                    Tercih ettiğiniz entegrasyon modeli:\t". $_SESSION['entegrasyonModel']."\n
                    Fatura adresiniz:\t". $_SESSION['faturaAdres']."\n
                    Şirket merkezi adresiniz:\t". $_SESSION['sirketAdres']."\n
                    Sevkiyat deposu adresiniz:\t". $_SESSION['depoAdres']."\n
                    İade deposu adresiniz:\t". $_SESSION['iadeAdres']."\n
                    Finans sorumlunuzun Adı ve soyadı:\t". $_SESSION['finansName']."\n
                    Finans sorumlunuzun Telefon numarası:\t". $_SESSION['finansPhone']."\n
                    Finans sorumlunuzun E-posta adresi:\t". $_SESSION['finansEmail']."\n
                    Müşteri Hizmetleri sorumlunuzun Adı ve soyadı:\t". $_SESSION['musteriName']."\n
                    Müşteri Hizmetleri sorumlunuzun Telefon numarası:\t". $_SESSION['musteriPhone']."\n
                    Müşteri Hizmetleri sorumlunuzun E-posta adresi:\t". $_SESSION['musteriEmail']."\n
                    Operasyon sorumlunuzun Adı ve soyadı:\t". $_SESSION['operasyonName']."\n
                    Operasyon sorumlunuzun Telefon numarası:\t". $_SESSION['operasyonPhone']."\n
                    Operasyon sorumlunuzun E-posta adresi:\t". $_SESSION['operasyonEmail']."\n
                ";
                $headers = "From: $from";
            
                // boundary 
                $semi_rand = md5(time()); 
                $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
            
                // headers for attachment 
                $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
            
                // multipart boundary 
                $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"utf-8\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
                $message .= "--{$mime_boundary}\n";
            
                // preparing attachments
                for($x=0;$x<count($files);$x++){
                    $file = fopen($files[$x],"rb");
                    $data = fread($file,filesize($files[$x]));
                    fclose($file);
                    $data = chunk_split(base64_encode($data));
                    $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" . 
                    "Content-Disposition: attachment;\n" . " filename=\"$files[$x]\"\n" . 
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                    $message .= "--{$mime_boundary}\n";
                }
            
                // send
            
                $ok = @mail($to, $subject, $message, $headers); 
                if ($ok) { 

                    if(file_exists($_SESSION['kimlikOn']))
                        unlink($_SESSION['kimlikOn']);
                    if(file_exists($_SESSION['kimlikArka']))
                        unlink($_SESSION['kimlikArka']);
                    if(file_exists($_SESSION['ikametgah']))
                        unlink($_SESSION['ikametgah']);
                    if(file_exists($_SESSION['vergiLevhe']))
                        unlink($_SESSION['vergiLevhe']);
                    if(file_exists($_SESSION['imza']))
                        unlink($_SESSION['imza']);
                    if (isset($_SESSION['gazete'])){
                        if(file_exists($_SESSION['gazete']))
                        unlink($_SESSION['gazete']);
                    }
                    if (isset($_SESSION['belge'])){
                        if(file_exists($_SESSION['belge']))
                        unlink($_SESSION['belge']);
                    }

                    session_destroy();
                    echo 1;
                    exit();
                } else { 
                    echo $ok;
                    exit();
                } 

                echo 10;
                exit();

            default:
                echo 5;
                exit();
        }

    }
}

?>