<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBidStatusNotification extends Notification
{
    use Queueable;
    public $bidStatusUpdate;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bidStatusUpdate)
    {
        $this->bidStatusUpdate = $bidStatusUpdate;
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
        // \Log::info(['buyer bid status' => $this->bidStatusUpdate]); 
        return [
            'notification_type' => 'bid_status',
            'bid_id'=> $this->bidStatusUpdate->id,
            'bid_status'=> $this->bidStatusUpdate->bid_status,
            'bid_seller_id'=> $this->bidStatusUpdate->seller_id,  
            'bid_buyer_id'=> $this->bidStatusUpdate->buyer_id,
            'product_name' =>$this->bidStatusUpdate->product->translation[0]->title,
            'seller_name' => $this->bidStatusUpdate->seller->name,
            'buyer_name' => $this->bidStatusUpdate->buyer->name,
        ];
    }


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
