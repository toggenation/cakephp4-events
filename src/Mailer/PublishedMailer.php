<?php

declare(strict_types=1);

namespace App\Mailer;

use Cake\Event\Event;
use Cake\Mailer\Mailer;

/**
 * Published mailer.
 */
class PublishedMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'Published';

    public function implementedEvents(): array
    {
        return [
            'Article.Published' => 'articlePublished'
        ];
    }

    public function articlePublished(Event $event)
    {
        /**
         * @var \App\Model\Entity\Article
         */
        $article = $event->getSubject();

        $this->setTo('user@example.com', 'Test User')
            ->setSubject("A new article has been published")
            ->deliver("A new article has been published with a title of \"{$article->title}\"");
    }
}
