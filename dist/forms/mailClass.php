<?php


  class FormData {



    public function prepare_html_img($data,$files){
      $html='';

      if (!empty($data['img-url'])) {
          $html.= '<strong>O URL da Imagem: </strong>
              <a href="'.$data['img-url'].'" target="_blank">'.$data['img-url'].'</a>';
      }
      if($files['error']=='0'){
            $html.= "<h3>Imagem Em Anexo</h3>";
      }

      return $html;
    }

    public function prepare_html_personalData($data){
      $html='
      <hr />
      <h3>Dados Pessoais</h3>
      <p>
        <strong>Nome:</strong>
        <cite>'.$data['info-personal']['name'].'</cite>
      </p>

      <p>
        <strong>Email:</strong>
        <cite>'.$data['info-personal']['email'].'</cite>
      </p>
      <p>
        <strong>Telefone:</strong>
        <cite>'.$data['info-personal']['phone'].'</cite>
      </p>
      <hr />
      <h3>Dados para Entrega/Colocação</h3>
      <p>
        <strong>Morada:</strong>
        <cite>'.$data['info-morada']['morada'].'</cite>
      </p>
      <p>
        <strong>Código Postal:</strong>
        <cite>'.$data['info-morada']['codPostal'].'</cite>
      </p><hr />';

      return $html;
    }

    public function prepare_form_Wall($data){
      $html="";
      if(isset($data['PUniforme'])){
          $P =$data['PUniforme'];
          if(!empty($P['altura']) && !empty($P['comprimento'])){
            $html.= '<hr />
            <h3>Parede Uniforme</h3>
            <p>
              <strong>Altura: </strong>
              <cite>'.$P['altura'].' cm</cite>
            </p>
            <p>
              <strong>Comprimento: </strong>
              <cite>'.$P['comprimento'].' cm</cite>
            </p>';
          }
      }

      if(isset($data['Pcomplexa'])){
          $P =$data['Pcomplexa'];
          $a = array_filter($P['Alturas']);
          $b = array_filter($P['Comprimentos']);
          if(!empty($a) & !empty($b)){
            $html.='<hr /><h3>Parede Complexa</h3>';

            $html.='<h4> - Alturas</h4>';
            $n1=1;
            foreach ($P['Alturas'] as $value) {
              $html.='<p>
                  <strong>A'.$n1.': </strong>
                  <cite>'.$value.' cm</cite>
                </p>';
                $n1++;
            }
          $n2=1;
          $html.='<h4> - Comprimentos</h4>';
          foreach ($P['Comprimentos'] as $value) {
            $html.='<p>
                <strong>C'.$n2.': </strong>
                <cite>'.$value.' cm</cite>
              </p>';
              $n2++;
          }
         }
      }
        if(!empty($data['Observacao'])&& $data['Observacao']!=''){
          $html.='<h4> - Observações</h4>
          <p>'.$data['Observacao'].'</p>';
      }



            $return = array(
              'html' =>$html      );
            return $return;
    }

    public function prepare_form_Canvas($data){
      $html='<h3>Medidas dos Canvas</h3>';
      $a = array_filter($data['produto']);
      if(!empty($a)){
        foreach ($data['produto'] as $value) {
          $html.='<p>
              <strong> Medida: </strong>
              <cite>'.$value['medidas'].'</cite>
               (
              <u><strong> '.$value['uni'].'</strong>
                <cite>uni</cite></u>
                )
              </p>';
        }
      }
      $b = array_filter($data['produtoPer']);
      if(!empty($b)){
        foreach ($data['produtoPer'] as $value) {
          $html.='<p>
              <strong> Medida: </strong>
              <cite>'.$value['medidas'].'</cite>
               (
              <u><strong> '.$value['uni'].'</strong>
                <cite>uni</cite></u>
                )
            </p>';
        }
      }


      $return = array(
        'html' =>$html      );
      return $return;
    }


    public function prepare_form_3D($data){

        $html='<h3>Medidas dos Impressão 3D</h3>';

        $a = array_filter($data['produto']);
        if(!empty($a)){
          $N=1;
          foreach ($data['produto'] as $value) {
            $html.='<p><h5>Pedido Nº'.$N.' </h5>
                <strong> Medida: </strong>
                <cite>'.$value['medidas'].'</cite>
                <br />
                <strong> Cor do PVC: </strong>
                <cite>'.$value['cor'].'</cite>
                <br />
                <strong> Espessura do PVC: </strong>
                <cite>'.$value['espessura'].'</cite>
                <br />
                <strong> Unidades: </strong>
                <cite>'.$value['uni'].'</cite>
                </p><hr />';
                $N++;
          }
        }

        if(!empty($data['Observacao'])|| $data['Observacao']!=''){
            $html.='<h4> - Observações</h4>
            <p>'.$data['Observacao'].'</p>';
        }


        $return = array(
          'html' =>$html ,
          );
        return $return;
      }

    public function prepare_form_Blinds($data){
      $html='<h3>Medidas das Blinds</h3>';
      $a = array_filter($data['produto']);
      if(!empty($a)){
        $N=1;
        foreach ($data['produto'] as $value) {
          $html.='<p><h5>Pedido Nº'.$N.' </h5>
              <strong> Medida: </strong>
              <cite>'.$value['medidas'].'</cite>
              <br />
              <strong> Tipo de Aplicação: </strong>
              <cite>'.$value['aplica'].'</cite>
              <br />
              <strong> Unidades: </strong>
              <cite>'.$value['uni'].'</cite>
              </p><hr />';
              $N++;
        }
      }

            $return = array(
              'html' =>$html      );
            return $return;
    }


    public function prepare_form_Tshirt($data){
      $html='<h3>Ordem de Pedidos de T-shirts </h3>';
      $a = array_filter($data['produto']);
      if(!empty($a)){
        $N=1;
        foreach ($data['produto'] as $value) {
          $html.='<p><h5>Pedido Nº'.$N.' </h5>
              <strong> Medida: </strong>
              <cite>'.$value['medidas'].'</cite>
              <br />
              <strong> Cor: </strong>
              <cite>'.$value['cor'].'</cite>
              <br />
              <strong> Unidades: </strong>
              <cite>'.$value['uni'].'</cite>
              </p><hr />';
              $N++;
        }
      }

            $return = array(
              'html' =>$html      );
            return $return;
    }

    public function prepare_form_Window($data){
      $html='<h3>Ordem de Pedidos - Vinil Windows</h3>';
      $a = array_filter($data['produto']);
      if(!empty($a)){
        $N=1;
        foreach ($data['produto'] as $value) {
          $html.='<p><h5>Pedido Nº'.$N.' </h5>
              <strong> Medida: </strong>
              <cite>'.$value['medidas'].'</cite>
              <br />
              <strong> Cor: </strong>
              <cite>'.$value['cor'].'</cite>
              <br />
              <strong> Unidades: </strong>
              <cite>'.$value['uni'].'</cite>
              </p><hr />';
              $N++;
        }
      }

            $return = array(
              'html' =>$html      );
            return $return;
    }
    /**
    *   UPLOAD de IMAGEM
    *
    * @path ../uploads/
    *
    */

    public function UploadImage($image){
          // Mime Type
          preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $image["name"], $ext);
          // File name
          $name = md5(uniqid(time())) . "." . $ext[1];
          // Path
          $path = "../uploads/" . $name;
          // Save
          move_uploaded_file($image["tmp_name"], $path);
          // Debug
          //echo $name;
          return $path;


    }



  }
/**
* A PHP class for sending email messages which includes capabilities for sending plaintext, html and multipart messages, including support for attachments.
*
* While none of the capabilities of this class exceed those of more established packages such as PEARMail, my hope is that this class offers the advantage of
* portability, since not every setup has the ability to install PEAR packages.  Also, this class is ideal for embedding in other systems, which I have done in
* the case of my MVC framework, DirtyMVC.
*
* @author Steve Lewis <steve@thoughtsandrambles.com>
* @version 0.1.0
* @package Mail
*
**/
  class Mail{
    /**
    * @var string $to The email address, (or addresses, if comma separated), of the person to which this email should be sent.
    **/
    public $to;

    /**
    * @var string $from The email address that this mail will be delivered from. Bear in mind that this can be anything, but that if the email
    *                   domain doesn't match the actual domain the message was sent from, some email clients will reject the message as spam.
    **/
    public $from;

    /**
    * @var string $subject The subject line of the email
    **/
    public $subject;

    /**
    * @var string $text_content The plaintext version of the message to be sent.
    **/
    public $text_content;

    /**
    * @var string $html_content The HTML version of the message to be sent.
    **/
    public $html_content;

    /**
    * @var string $body The complete body of the email that will be sent, including all mixed content.
    **/
    public $body;

    /**
    * @var array $attachments  An array of file paths pointing to the attachments that should be included with this email.
    **/
    public $attachments;

    /**
    * @var array $headers An array of the headers that will be included in this email.
    **/
    public $headers;

    /**
    * @var string $header_string The string, (and therefore final), representation of the headers for this email message.
    **/
    public $header_string;

    /**
    * @var string $boundary_hash The string that acts as a separator between the various mixed parts of the email message.
    **/
    public $boundary_hash;

    /**
    * @var boolean $sent Whether or not this email message was successfully sent.
    **/
    public $sent;


    /**
    * Upon initialization of a Mail object, you have to pass it certain vital pieces of information.
    *
    * At a minimum, an email must consist of a receiver address, a sender address, and a subject.
    * The body can be left blank.
    **/
    public function __construct($to, $from, $subject, $text_content = "", $html_content = ""){
      $this->to            = $to;
      $this->from          = $from;
      $this->subject       = $subject;
      $this->text_content  = $text_content;
      $this->html_content  = $html_content;
      $this->body          = "";
      $this->attachments   = array();
	  $this->base64_attachments   = array();
      $this->headers       = array();
      $this->boundary_hash = md5(date('r', time()));
    }

    /**
    * The send() method processes all headers, body elements and attachments and then actually sends the resulting final email.
    **/
    public function send(){
      $this->prepare_headers();
      $this->prepare_body();
      if(!empty($this->attachments)){
        $this->prepare_attachments();
      }
      if(!empty($this->base64_attachments)){
        $this->prepare_base64_attachments();
      }
      $this->sent = mail($this->to, $this->subject, $this->body, $this->header_string);
      return $this->sent;
    }

    /**
    * This method allows the user to add a new header to the message
    * @param string $header The text for the header the user wants to add. Note that this string must be a properly formatted email header.
    **/
    public function add_header($header){
      $this->headers[] = $header;
    }

    /**
    * Add a filepath to the list of files to be sent with this email.
    * @param string $file The path to the file that should be sent.
    **/
    public function add_attachment($file){
      $this->attachments[] = $file;
    }
    public function add_base64_attachment($name,$data){
      $this->base64_attachments[] = array('name'=>$name, 'data'=>$data);
    }
    private function prepare_body(){
      $this->body .= "--PHP-mixed-{$this->boundary_hash}\n";
      $this->body .= "Content-Type: multipart/alternative; boundary=\"PHP-alt-{$this->boundary_hash}\"\n\n";
      if(!empty($this->text_content)) $this->prepare_text();
      if(!empty($this->html_content)) $this->prepare_html();
      $this->body .= "--PHP-alt-{$this->boundary_hash}--\n\n";
    }

    private function prepare_headers(){
      $this->set_default_headers();
      $this->header_string = implode(PHP_EOL, $this->headers).PHP_EOL;
    }

    private function set_default_headers(){
      $this->headers[] = 'MIME-Version: 1.0';
      $this->headers[] = "From: {$this->from}";
      $this->headers[] = "To: {$this->to}";
      $this->headers[] = "Subject: {$this->subject}";
      # We'll assume a multi-part message so that we can include an HTML and a text version of the email at the
      # very least. If there are attachments, we'll be doing the same thing.
      $this->headers[] = "Content-type: multipart/mixed; boundary=\"PHP-mixed-{$this->boundary_hash}\"";
    }

    private function prepare_base64_attachments(){
      foreach($this->base64_attachments as $attachment){

        $this->body .= "--PHP-mixed-{$this->boundary_hash}\n";
        $this->body .= "Content-Type: application/octet-stream; name=\"{$attachment['name']}\"\n";
        $this->body .= "Content-Transfer-Encoding: base64\n";
        $this->body .= "Content-Disposition: attachment\n\n";
        $this->body .= chunk_split($attachment['data']);
        $this->body .= "\n\n";
      }
      $this->body .= "--PHP-mixed-{$this->boundary_hash}--\n\n";
    }

    private function prepare_attachments(){
      foreach($this->attachments as $attachment){
        $file_name  = basename($attachment);

        $this->body .= "--PHP-mixed-{$this->boundary_hash}\n";
        $this->body .= "Content-Type: application/octet-stream; name=\"{$file_name}\"\n";
        $this->body .= "Content-Transfer-Encoding: base64\n";
        $this->body .= "Content-Disposition: attachment\n\n";
        $this->body .= chunk_split(base64_encode(file_get_contents($attachment)));
        $this->body .= "\n\n";
      }
      $this->body .= "--PHP-mixed-{$this->boundary_hash}--\n\n";
    }


    private function prepare_text(){
      $this->body .= "--PHP-alt-{$this->boundary_hash}\n";
      $this->body .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
      $this->body .= "Content-Transfer-Encoding: 7bit\n\n";
      $this->body .= $this->text_content."\n\n";
    }

    private function prepare_html(){
      $this->body .= "--PHP-alt-{$this->boundary_hash}\n";
      $this->body .= "Content-Type: text/html; charset=\"utf-8\"\n";
      $this->body .= "Content-Transfer-Encoding: 7bit\n\n";
      $this->body .= $this->html_content."\n\n";
    }

  }
