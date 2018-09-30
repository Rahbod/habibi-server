<?php
class Mailer
{
    /**
     * Send mail
     *
     * @param $to string
     * @param $subject string
     * @param  $message string
     * @param $from string
     * @param $SMTP array
     * @param $attachments array
     * @param $template string template view file path
     * @param $templateParams array template params array
     *
     * @throws CException if type of attachment not is set.
     *
     * @return bool
     */
    public static function mail($to, $subject, $message, $from, $SMTP = array(), $attachments = array(), $template = null, $templateParams = array())
    {
        Yii::app()->controller->beginClip('mailTheme');
        Yii::app()->controller->renderPartial($template?:'//layouts/_mail_theme', $templateParams);
        Yii::app()->controller->endClip();
        $mailTheme = Yii::app()->controller->clips['mailTheme'];
        $mailTheme = str_replace('{CurrentYear}', JalaliDate::date('Y'), $mailTheme);
        $message = str_replace('{MessageBody}', $message, $mailTheme);
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer;
        $mail->CharSet = 'UTF-8';
        if($SMTP && isset($SMTP['Host']) && isset($SMTP['Secure']) && isset($SMTP['Username']) && isset($SMTP['Password']) && isset($SMTP['Port'])){
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = $SMTP['Host'];
            $mail->SMTPSecure = $SMTP['Secure'];
            $mail->Username = $SMTP['Username'];
            $mail->Password = $SMTP['Password'];
            $mail->Port = (int)$SMTP['Port'];
            $mail->SetFrom($SMTP['Username'], Yii::app()->name);
        }else
            $mail->SetFrom($from, Yii::app()->name);

        if(is_array($to))
            foreach($to as $email)
                $mail->AddAddress($email);
        else
            $mail->AddAddress($to);
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Body = $message;
        $mail->Subject = $subject;
        if($attachments){
            foreach($attachments as $attachment){
                if($attachment){
                    if(!isset($attachment['method']))
                        throw new CException('attachment method must be set.', 500);
                    $encoding = (isset($attachment['encoding']))?$attachment['encoding']:'base64';
                    $type = (isset($attachment['type']))?$attachment['type']:'application/octet-stream';
                    if($attachment['method'] == 'string')
                        $mail->AddStringAttachment($attachment['string'], $attachment['filename'], $encoding, $type);
                    else
                        $mail->AddAttachment($attachment['path'], $attachment['name'], $encoding, $type);
                }
            }
        }
        return @$mail->Send();
    }
}