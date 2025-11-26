<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Yuk Jajan - Status Pesanan Diperbarui')
            ->greeting('Hai, ' . $notifiable->name . '!')
            ->line('Status pesanan kamu **#' . $this->order->id . '** telah diperbarui menjadi: **' . ucfirst($this->order->status) . '**.')
            ->action('Lihat Pesanan', url('/orders'))
            ->line('Terima kasih telah menggunakan Yuk Jajan!');
    }
}