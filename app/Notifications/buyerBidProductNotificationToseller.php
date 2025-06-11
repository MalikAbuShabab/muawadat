<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class buyerBidProductNotificationToseller extends Notification
{
    use Queueable;
    public $newBidFromBuyerToSeller;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($newBidFromBuyerToSeller)
    {
        $this->newBidFromBuyerToSeller = $newBidFromBuyerToSeller;
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
            'notification_type' => 'newBidRequestNotifyToToSeller',
            'bid_id'=> $this->newBidFromBuyerToSeller->id,
            'bid_status'=> $this->newBidFromBuyerToSeller->bid_status,
            'bid_seller_id'=> $this->newBidFromBuyerToSeller->seller_id,  
            'bid_buyer_id'=> $this->newBidFromBuyerToSeller->buyer_id,
            'product_name' =>$this->newBidFromBuyerToSeller->product->translation[0]->title,
            'seller_name' => $this->newBidFromBuyerToSeller->seller->name,
            'buyer_name' => $this->newBidFromBuyerToSeller->buyer->name,
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
