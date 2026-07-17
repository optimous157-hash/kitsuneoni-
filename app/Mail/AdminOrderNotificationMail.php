<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminOrderNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Order — {$this->order->reference_number}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin-order-notification',
            with: [
                'order' => $this->order,
                'items' => $this->order->items,
            ],
        );
    }
}
