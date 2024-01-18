<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomSendEmail;
use App\Mail\NotifyMail;
use App\Mail\EmailVerification;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    public $subject;
    public $view;
    public $content;
    public $email;
    public $emailType;
    public $fromName;

    public function __construct($emailType,$email,$subject="",$view="",$content,$fromName="")
    {
        $this->emailType = $emailType;
        $this->email = $email;
        $this->subject=$subject;
        $this->view=$view;
        $this->content=$content;
        $this->fromName=$fromName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // Send the email using the Mail facade
        switch ($this->emailType) {
            case 'notifyEmail':
                Mail::to($this->email)->send(new NotifyMail($this->subject, $this->view, $this->content));
                break;
            case 'verificationEmail':
                Mail::to($this->email)->send(new EmailVerification($this->content));
                break;
            case 'customeEmail':
                Mail::to($this->email)->send(new CustomSendEmail($this->subject, $this->view, $this->content));
                break;
            // Add more cases for other email types if needed
            case 'forgetPasswordEmail':
                $email = $this->email;
                Mail::send($this->view, ['token' => $this->content], function($message) use($email){
                    $message->to($email);
                    $message->subject('Reset Password');
                });
                break;
            case 'sendCustomEmails':
                $emails = explode(',', $this->email); // Split the comma-separated string into an array
                $subject = $this->subject;
                $fromName = $this->fromName;
                Mail::send($this->view, ['content' => $this->content], function($message) use($emails,$subject,$fromName){
                    $message->to($emails);
                    $message->subject($subject);
                    $message->from('your@example.com', $fromName); // Set only the "from name"
                });
                break;
            default:
                break;
        }
        
        
    }
}
