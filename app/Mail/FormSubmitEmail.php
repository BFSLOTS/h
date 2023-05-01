<?php

namespace App\Mail;

use App\Models\FormValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormSubmitEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $form_value;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FormValue $form_value)
    {
        $this->form_value = $form_value;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.form_submit')->with('form_value',$this->form_value)->subject('New survey Submited - '. $this->form_value->Form->title);
    }
}
