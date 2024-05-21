<?php

namespace App\Jobs;

use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\PHPMailerService;
use Illuminate\Support\Facades\Log;

class SendFormCreatedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $form;

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function handle(PHPMailerService $mailer)
    {
        $to = 'hashirbinali@gmail.com';
        $subject = 'New Form Created';
        $body = "A new form '{$this->form->name}' has been created.";

        $mailer->send($to, $subject, $body);
    }
}
