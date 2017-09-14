<?php

namespace App\Mail;
use App\ConcatPdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class pdfmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $name)
    {
        $this->data = $data;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        // connect to database

        // foreach user in the database
            //  add to array1 the title
            // add to array2 the path to pdfs
        // concatenate the pdf files and the titles
        //send email to the user
        //next

        // after the boucle finishes delete the content of the table

        $path = $this->data;
        $name = $this->name;
        $address = 'm.harbouj@gmail.com';
        $from = 'Oxdata';
        $subject = 'Newslettre I-Media';
        return $this->view('emails.pdf', compact('path','name'))
                ->from($address, $from) 
                ->subject($subject);
                /*->cc($address, $name)
                ->bcc($address, $name)
                ->replyTo($address, $name)*/
    }
}
