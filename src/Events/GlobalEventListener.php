<?php

namespace App\Events;

use App\Model\Entity\Article;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use App\Model\Table\ArticlesTable;

class GlobalEventListener implements EventListenerInterface
{

    public function implementedEvents(): array
    {
        return [
            'MyCustomEvent.Event' => 'myFunc',
            "Model.beforeSave" => 'globalBeforeSave'
        ];
    }


    public function myFunc(EventInterface $event)
    {
    }

    public function globalBeforeSave(
        EventInterface $event,
        EntityInterface $entity,
        ArrayObject $options
    ): void {

        // if ($event->getSubject() instanceof ArticlesTable) {
        //     dd([$event->getSubject(), $event->getData()]);
        // }

        // if ($entity instanceof Article) {
        //     dd(Article::class);
        // }

        // if ($entity instanceof ) {
        // dd("Article!!!");
        // }
    }
}
