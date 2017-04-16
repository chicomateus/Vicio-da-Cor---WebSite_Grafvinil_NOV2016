<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

date_default_timezone_set('Europe/Lisbon');

include 'mailClass.php';
$today = date("F j, Y, g:i a");
$form  = new FormData();

// echo "<pre>";
// print_r($_FILES);
//   print_r($_POST);
// echo "</pre>";

if (isset($_POST['data']['form'])){
  //----------- DEFINIR VARIAVEIS

  $data =$_POST['data'];

  switch ($data['form']) {
    case 'WALL':

      $array= $form->prepare_form_Wall($data['Wall-Medidas']);
      $html=$array['html'];

    break;
    case 'CANVAS':
    $array= $form->prepare_form_Canvas($data);
    $html=$array['html'];


    break;
    case '3D':

      $array= $form->prepare_form_3D($data);
      $html=$array['html'];

    break;
    case 'BLINDS':

      $array= $form->prepare_form_Blinds($data);
      $html=$array['html'];


    break;
    case 'TSHIRT':
    $array= $form->prepare_form_Tshirt($data);
    $html=$array['html'];


    break;
    case 'WINDOWS':

    $array= $form->prepare_form_Window($data);
    $html=$array['html'];

    break;

  }



  if($_FILES['data']['error']== 0 ){
      $image = $_FILES['data'];
      if(preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $image['type']))
      {

      $path_img = $form->UploadImage($image);
      }
  }

  //// Configuração de Emails

  /* Email de quem gere e recebe as encomendas*/
  $email_main="rmvrocha@gmail.com";
  /* Email de envio - tem de ser diferente do $email_main */
  $email_sender="noreply@spaziocolorato.pt";
  /* Email do cliente - para envio de copia e confirmação da encomenda*/
  $client_email= $_POST['data']['main']['info-personal']['email'];

// A ENVIAR O EMAIL para o Gestor de Encomendas

    $to        = $email_main;
    $from      = $email_sender;
    $subject   = "Nova Encomenda - ".$_POST['data']['form']." - ".$today;
    $html_body = '<h2>Nova Encomenda - '.$_POST['data']['form'].'</h2>';
    $html_body.=" <p><strong>Data do pedido</strong> ".$today.'</p>';
    $html_body.= $form->prepare_html_personalData($_POST['data']['main']);
    $html_body.= $html;

    $html_body.= $form->prepare_html_img($_POST['data']['Img'],$_FILES['data']);

    $mail   = new Mail($to, $from, $subject,'', $html_body);

    //ADD ANEXO - IMAGEM POR ANEXO
    if(!empty($path_img)){
        $mail->add_attachment($path_img);
    }
//_____________________
    $mail->add_header("Reply-To: ".$client_email);
    $sucess = $mail->send();

    if($sucess){
      echo "enviado com sucesso - " . $sucess;
    }else{
      echo "não enviado, tente outra x";
    }
    // A ENVIAR O EMAIL de copia para o cliente

        $to        = $client_email;
        $from      = $email_sender;
        $subject   = "Pedido de Orçamento - ".$_POST['data']['form'] ;
        $html_body = '<h2>Nova Encomenda - '.$_POST['data']['form'].'</h2>';
        $html_body.=" <p><strong>Data do pedido</strong> ".$today.'</p>';
        $html_body.= $form->prepare_html_personalData($_POST['data']['main']);
        $html_body.= $html;

        $html_body.= $form->prepare_html_img($_POST['data']['Img'],$_FILES['data']);

        $mail   = new Mail($to, $from, $subject,'', $html_body);

        //ADD ANEXO - IMAGEM POR ANEXO
        if(!empty($path_img)){
            $mail->add_attachment($path_img);
        }
    //_____________________
        $mail->add_header("Reply-To: ".$client_email);
        $second = $mail->send();

        if($second){
          echo "||| 2enviado com sucesso - " . $second;
        }else{
          echo "não enviado, tente outra x";
        }

}
?>
