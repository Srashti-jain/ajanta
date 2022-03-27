<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\CustomDbChannel;

class FullOrderCancelNotificationAdmin extends Notification
{
    use Queueable;

    public $inv_cus;
    public $order_id;
    public $mstatus;
    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($inv_cus,$order_id,$mstatus)
    {   
        $this->inv_cus    = $inv_cus;
        $this->order_id   = $order_id;
        $this->mstatus    = $mstatus;
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomDbChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    
    public function toDatabase($notifiable)
    {
        return [

            'data' => 'Order #'.$this->inv_cus->order_prefix.$this->order_id.' has been '.$this->mstatus,
            'n_type' => 'order_v',
            'url' => 'admin/ord/canceled/'

        ];
    }
}
