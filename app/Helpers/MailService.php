<?php
namespace App\Helpers;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
class MailService{
    static function yazGonder($to, $subject, $content){
        if($to){
            $data['subject']=$subject;
            $data['content']=$content;
            $data['hash_token']= _getHashToken($to);
            $body = view('emails.yaz-gonder', $data);
            self::sendEmail($to, $subject, $body);
        }
    }
    public static function resetPassword($email,$password){

        $data['email']=$email;
        $data['password']=$password;
        $body = view('emails.reset-password', $data)->render();
        $subject = 'Akıllı Phone Yeni Şifre';
        self::sendEmail($email, $subject, $body);
    }
    static function newOrder($data){
        if($data['order']){
            $to = $data['order']->email;
            $body = view('emails.new-order', $data)->render();
            $subject = 'Siparişiniz Hakkında';
            self::sendEmail($to, $subject, $body);
            //self::sendEmail('balcioglualisahin@gmail.com', $subject, $body);
        }
    }
    static function newMember($member){
        if($member){
            $to = $member->email;
            $body = view('emails.new-member', ['member'=>$member])->render();
            $subject = 'Üyeliğiniz Hakkında';
            self::sendEmail($to, $subject, $body);

            //self::sendEmail('balcioglualisahin@gmail.com', $subject, $body);
        }
    }
    private static function sendEmail($to, $subject, $body, $from=null) : bool
    {

        try {
            if(!$from){
                $from = env('MAIL_USERNAME');
            }
            $mailable = new AkilliEmail();

            $mailable
                ->from($from)
                ->to($to)
                ->subject($subject)
                ->html($body);
            if($to != env('ADMIN_EMAIL')){
                if(env('ADMIN_EMAIL')){
                    $mailable
                        ->to(env('ADMIN_EMAIL'));
                }
            }
            $result = Mail::send($mailable);
            return true;
        } catch (\Symfony\Component\Mailer\Exception\TransportException $exception) {
            if(env('ADMIN_EMAIL')){
                $mailable
                    ->from($from)
                    ->to(env('ADMIN_EMAIL'))
                    ->subject('Gönderilemedi | '.$subject)
                    ->html($body);
            }

            return false;
        }
    }
}

class AkilliEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return true;//$this->view('view.name');
    }
}
