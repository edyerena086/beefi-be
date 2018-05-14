<?php

namespace MetodikaTI\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use MetodikaTI\User;

class RecoverPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;

        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@beeplot.com', 'BeePlot')
                    ->view('emails.recovery-password')
                    ->with([
                        'name' => $this->user->name,
                        'password' => $this->password
                    ]);
    }
}
