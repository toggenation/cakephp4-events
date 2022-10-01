<?php

declare(strict_types=1);

namespace App\Mailer;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Mailer\Mailer;

/**
 * Published mailer.
 */
class PublishedMailer extends Mailer implements EventListenerInterface
{
    public function implementedEvents(): array
    {
        return [
            'Article.Published' => 'notifyPublished'
        ];
    }
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'Published';

    public function notifyPublished(Event $event)
    {
        $article = $event->getSubject();
        // dd([
        //     $event->getSubject(),
        //     $event->getData()
        // ]);
        $this->viewBuilder()
            ->setTemplate('default');

        $this->addTo('james@toggen.com.au')
            ->setSubject($article->title)
            ->setEmailFormat('both')
            ->setViewVars(['content' => "A new article has been published"])
            ->send();
    }
}
