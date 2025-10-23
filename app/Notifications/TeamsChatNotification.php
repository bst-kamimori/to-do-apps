<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsAdaptiveCard;
use NotificationChannels\MicrosoftTeams\ContentBlocks\TextBlock;
use NotificationChannels\MicrosoftTeams\ContentBlocks\FactSet;
use NotificationChannels\MicrosoftTeams\ContentBlocks\Fact;
use NotificationChannels\MicrosoftTeams\Actions\ActionOpenUrl;


class TeamsChatNotification extends Notification
{
//    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function via($notifiable)
    {
        return [MicrosoftTeamsChannel::class];
    }

    public function toMicrosoftTeams($notifiable)
    {
        return MicrosoftTeamsAdaptiveCard::create()
            ->to(config('services.microsoft_teams.webhook_url'))
            ->title('Subscription Created')
            ->content([
                TextBlock::create()
                    ->setText('Yey, you got a **new subscription**.')
                    ->setFontType('Monospace')
                    ->setWeight('Bolder')
                    ->setSize('ExtraLarge')
                    ->setSpacing('ExtraLarge')
                    ->setStyle('Heading')
                    ->setHorizontalAlignment('Center')
                    ->setSeparator(true),
                FactSet::create()
                    ->setSpacing('ExtraLarge')
                    ->setSeparator(true)
                    ->setFacts([
                        Fact::create()->setTitle('Subscription Created')->setValue('Today'),
                    ])
            ])
            ->actions([
                ActionOpenUrl::create()
                    ->setMode('Primary')
                    ->setStyle('Positive')
                    ->setTitle('Contact Customer')
                    ->setUrl("https://www.tournamize.com"),
            ]);
    }
}
