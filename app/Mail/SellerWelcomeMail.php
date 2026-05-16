<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Seller $seller) {}

    public function build()
    {
        return $this->subject('Welcome to ShopSphere Seller Hub')
            ->view('emails.seller-welcome');
    }
}
