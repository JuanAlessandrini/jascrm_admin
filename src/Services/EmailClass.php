<?php
namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailClass extends AbstractController{

    public function sendMail($sendTos, $attachments, $subject, $bodyHtml, $bodyAlt): JsonResponse{
            try {
                $smtpUsuario = $_ENV['MAIL_USER_ACCOUNT'];  // Mi cuenta de correo
                $smtpClave = $_ENV['MAIL_USER_PWD'];  // Mi contraseña
                
                $mail = new PHPMailer(true);
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = $_ENV['MAIL_DOMAIN'];                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;  
                $mail->Port       = 465;                                   //Enable SMTP authentication
                $mail->Username   = $smtpUsuario;                     //SMTP username
                $mail->Password   = $smtpClave;                               //SMTP password
                $mail->isHTML(true);   
                //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    
                

                //Recipients
                $mail->setFrom($smtpUsuario, 'Admin');
                $mail->addReplyTo($smtpUsuario, 'Admin');

                foreach($sendTos as $sendTo){
                    $mail->addAddress($sendTo['mail'], $sendTo['name']);     //Add a recipient
                }
                
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                

                //Attachments
                if(!empty($attachments)){
                    foreach($attachments as $attachment){
                        $mail->addAttachment($attachment['path'], $attachment['name']);    //Optional name
                    }
                }
                //Content
                $bodyFile = file_get_contents(__DIR__.'/mailhtml.html');
                $bodyFile = str_replace("[mailBody]", $bodyHtml,$bodyFile);
                                            //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $bodyFile;
                $mail->AltBody = $bodyAlt;
                $mail->CharSet = "utf-8";
                
                
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->send();
                    return new JsonResponse ('Message has been sent');
                } catch (Exception $e) {
                    return new JsonResponse ( "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                }
            
        }

        public function sendInfoMail($sendTos, $attachments, $subject, $bodyHtml, $bodyAlt): JsonResponse{
            try {
                $smtpUsuario = $_ENV['MAIL_INFO_ACCOUNT'];  // Mi cuenta de correo
                $smtpClave = $_ENV['MAIL_INFO_PWD'];  // Mi contraseña
                
                $mail = new PHPMailer(true);
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = "mail.camaracacsylsur.org.ar";                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;  
                $mail->Port       = 587;                                   //Enable SMTP authentication
                $mail->Username   = $smtpUsuario;                     //SMTP username
                $mail->Password   = $smtpClave;                               //SMTP password
                $mail->isHTML(true);   
                //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    
                

                //Recipients
                $mail->setFrom($smtpUsuario, 'Admin');
                $mail->addReplyTo($smtpUsuario, 'Admin');

                foreach($sendTos as $sendTo){
                    $mail->addAddress($sendTo['mail'], $sendTo['name']);     //Add a recipient
                }
                
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                

                //Attachments
                if(!empty($attachments)){
                    foreach($attachments as $attachment){
                        $mail->addAttachment($attachment['path'], $attachment['name']);    //Optional name
                    }
                }
                //Content
                $bodyFile = file_get_contents(__DIR__.'/mailhtml.html');
                $bodyFile = str_replace("[mailBody]", $bodyHtml,$bodyFile);
                                            //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $bodyFile;
                $mail->AltBody = $bodyAlt;
                $mail->CharSet = "utf-8";
                
                
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->send();
                    return new JsonResponse ('Message has been sent');
                } catch (Exception $e) {
                    return new JsonResponse ( "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                }
            
        }
    public function enviarPublicidad($file, $subject,$sendTos, $attachment){
        try {
            $smtpUsuario = $_ENV['MAIL_USER_ACCOUNT'];  // Mi cuenta de correo
            $smtpClave = $_ENV['MAIL_USER_PWD'];  // Mi contraseña
            
            $mail = new PHPMailer(true);
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = "mail.medicalapp.ar";                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;  
            $mail->Port       = 465;                                   //Enable SMTP authentication
            $mail->Username   = $smtpUsuario;                     //SMTP username
            $mail->Password   = $smtpClave;                               //SMTP password
            $mail->isHTML(true);   
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                
            

            //Recipients
            $mail->setFrom($smtpUsuario, 'Medical App');
            $mail->addReplyTo($smtpUsuario, 'Medical App');

            foreach($sendTos as $sendTo){
                $mail->addAddress($sendTo['mail'], $sendTo['name']);     //Add a recipient
            }
            
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            

            //Attachments
            if(!empty($attachments)){
                foreach($attachments as $attachment){
                    $mail->addAttachment($attachment['path'], $attachment['name']);    //Optional name
                }
            }
            //Content
            $bodyFile = file_get_contents(__DIR__.'/'.$file.'.html');
            // $bodyFile = str_replace("[mailBody]", $bodyHtml,$bodyFile);
                                        //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $bodyFile;
            // $mail->AltBody = $bodyAlt;
            $mail->CharSet = "utf-8";
            
            
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();
                return new JsonResponse ('Message has been sent');
            } catch (Exception $e) {
                return new JsonResponse ( "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
    }

    public function sendEmailConfirmationTurno($emailPaciente, $nombrePaciente, $apellidoPaciente, $nombreApellidoMedico, $horario, $hashCancel){
        $bodyHTML="<div class='divBody'>
                <div>Hola ".$nombrePaciente."</div>
                <div>Te recordamos que mañana tenés un turno con ".$nombreApellidoMedico." a las <b>".$horario."</b></div>
                <div>Te esperamos!</div>
                <div>Si no puedes asistir, por favor cancela el turno haciendo click en este <a href='https://www.medicalapp.ar/api/mail/cancel/turno/".$hashCancel."'>link</a></div>
            </div>";
            $bodyAlt = "Hola ".$nombrePaciente.".Te recordamos que mañana tenés un turno con ".$nombreApellidoMedico." a las <b>".$horario.". Si no puedes asistir, por favor cancela el turno haciendo click en este link: https://www.medicalapp.ar/messagebird/mail/cancel/turno/".$hashCancel;
        return $this->sendMail(array([
            'mail'=>$emailPaciente, 
            'name'=>$nombrePaciente.' '.$apellidoPaciente
            ]), [], "Confirmación de Turno", $bodyHTML, $bodyAlt);
    }

    public function sendRecoveryPasswordEmail($user, $resetToken, $bodyHtml, $bodyAlt){
        // try {
                  
                $this->sendMail(Array([
                    'name'=>$user->getFullName(),
                    'mail'=>$user->getEmail()
                ]), [], 'Recupero de Contraseña', $bodyHtml, $bodyAlt);
            
        // } catch (\Throwable $th) {
        //     throw new \Exception("Error enviando Email", 1);
            
        // }
    }
}