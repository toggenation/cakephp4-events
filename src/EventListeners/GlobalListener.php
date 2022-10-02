<?php

namespace App\EventListeners;

use App\Model\Entity\Article;
use App\Model\Table\ArticlesTable;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;

class GlobalListener implements EventListenerInterface
{

    public function implementedEvents(): array
    {
        return [
            'Global.Event' => 'globalEvent',
            "Model.afterSave" => 'globalAfterSave'
        ];
    }

    public function globalAfterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void
    {
        if ($entity instanceof Article) {
            dd($event->getData('entity'));
        }
    }

    public function globalEvent(Event $event, $view, $data)
    {
        // did some stuff

        // [ 'result' => ]
        $event->setResult("Successfully did a global event");

        // dd([
        //     $event->getSubject(),
        //     $event->getData('view'),
        //     $view,
        //     $data
        // ]);
    }
}
