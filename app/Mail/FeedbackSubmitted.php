<?php

namespace App\Mail;

use App\Models\FeedbackMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public FeedbackMessage $feedback;

    public function __construct(FeedbackMessage $feedback)
    {
        $this->feedback = $feedback;
    }

    public function build(): self
    {
        return $this
            ->subject('Обращение с инфомата')
            ->view('mail.feedback-submitted');
    }
}
