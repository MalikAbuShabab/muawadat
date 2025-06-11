<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ownerShipTransferNotification extends Notification
{
    use Queueable;
    public $ownerShipTransfer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ownerShipTransfer)
    {
        $this->ownerShipTransfer = $ownerShipTransfer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

     public function toDatabase($notifiable)
    {
        return [
            'notification_type' => 'ownershipTransferToBuyer',
            'bid_id'=> $this->ownerShipTransfer->id,
            'bid_status'=> $this->ownerShipTransfer->bid_status,
            'bid_seller_id'=> $this->ownerShipTransfer->seller_id,  
            'bid_buyer_id'=> $this->ownerShipTransfer->buyer_id,
            'product_name' =>$this->ownerShipTransfer->product->translation[0]->title,
            'seller_name' => $this->ownerShipTransfer->seller->name,
            'buyer_name' => $this->ownerShipTransfer->buyer->name,
        ];
    }

    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
