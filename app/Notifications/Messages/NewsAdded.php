<?php

namespace App\Notifications\Messages;

use App\Contracts\Notification;
use App\Models\News;
use App\Notifications\Channels\Discord\DiscordMessage;
use App\Notifications\Channels\MailChannel;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsAdded extends Notification implements ShouldQueue
{
    use MailChannel;

    public $requires_opt_in = true;

    public function __construct(
        private readonly News $news
    ) {
        parent::__construct();

        $this->setMailable(
            $news->subject,
            'notifications.mail.news.news',
            ['news' => $news]
        );
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * @param News  $news
     * @param mixed $notifiable
     *
     * @return DiscordMessage|null
     */

    /*
     * DASHED OUT ON PURPOSE TO FIX ISSUE  #1741
     * AS IT GENERATES EXCEPTIONS DUE TO MISSING USER OBJECT
     * AND GENERATES MULTIPLE MESSAGES IN DISCORD
     *
        public function toDiscordChannel($news): ?DiscordMessage
        {
            if (empty(setting('notifications.discord_public_webhook_url'))) {
                return null;
            }

            $dm = new DiscordMessage();
            return $dm->webhook(setting('notifications.discord_public_webhook_url'))
                ->success()
                ->title('News: '.$news->subject)
                ->author([
                    'name'     => $news->user->ident.' - '.$news->user->name_private,
                    'url'      => '',
                    'icon_url' => $news->user->resolveAvatarUrl(),
                ])
                ->description($news->body);
        }
    *
    */

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'news_id' => $this->news->id,
        ];
    }
}
