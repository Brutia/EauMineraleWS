<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\IonicPushNotifications\IonicPushChannel;
use NotificationChannels\IonicPushNotifications\IonicPushMessage;

class Info extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($titre, $message)
    {
        $this->titre = $titre;
        $this->message = $message;
    }

   

    

    
    public function via($notifiable)
    {
    	return [IonicPushChannel::class];
    }
    
    public function toIonicPush($notifiable)
    {
    	return IonicPushMessage::create('android')
						    	->title($this->titre)
						    	->message($this->message)
						    	->sound('ping.aiff')
						    	->payload(['foo' => 'bar']);
    	
    }
}
