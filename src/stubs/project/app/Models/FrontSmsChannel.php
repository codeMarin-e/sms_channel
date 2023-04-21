<?php
    namespace App\Models;

    use Illuminate\Notifications\Notification;

    class FrontSmsChannel {

        // @HOOK_TRAITS

        /**
         * Send the given notification.
         *
         * @param  mixed  $notifiable
         * @param  \Illuminate\Notifications\Notification  $notification
         * @return void
         */
        public function send($notifiable, Notification $notification)
        {
            $message = $notification->toFrontSMS($notifiable, app()->make('FrontSms'));

            // Send notification to the $notifiable instance...
        }
    }
