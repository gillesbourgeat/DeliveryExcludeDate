<?php
/*************************************************************************************/
/*      This file is part of the module DeliveryExcludeDate                          */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace DeliveryExcludeDate\Action;

use DeliveryExcludeDate\Event\DateIsAvailableEvent;
use DeliveryExcludeDate\Event\DatesIsAvailableEvent;
use DeliveryExcludeDate\Model\DeliveryExcludeDate;
use DeliveryExcludeDate\Model\DeliveryExcludeDateQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DeliveryExcludeDate\Event\DeliveryExcludeDateEvent;
use DeliveryExcludeDate\Event\DeliveryExcludeDateEvents;
use Thelia\Action\BaseAction;
use DeliveryExcludeDate\DeliveryExcludeDate as DeliveryExcludeDateCore;

/**
 * Class DeliveryExcludeDateAction
 * @package DeliveryExcludeDate\Action
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DeliveryExcludeDateAction extends BaseAction implements EventSubscriberInterface
{
    /**
     * @param DeliveryExcludeDateEvent $event
     */
    public function create(DeliveryExcludeDateEvent $event)
    {
        $event->getDeliveryExcludeDate()->save($event->getConnectionInterface());
    }

    /**
     * @param DeliveryExcludeDateEvent $event
     */
    public function update(DeliveryExcludeDateEvent $event)
    {
        $event->getDeliveryExcludeDate()->save($event->getConnectionInterface());
    }

    /**
     * @param DeliveryExcludeDateEvent $event
     */
    public function delete(DeliveryExcludeDateEvent $event)
    {
        $event->getDeliveryExcludeDate()->delete($event->getConnectionInterface());
    }

    /**
     * @param DeliveryExcludeDateEvent $event
     */
    public function enable(DeliveryExcludeDateEvent $event)
    {
        $event->getDeliveryExcludeDate()->setActive(1);
        $event->getDeliveryExcludeDate()->save($event->getConnectionInterface());
    }

    /**
     * @param DeliveryExcludeDateEvent $event
     */
    public function disable(DeliveryExcludeDateEvent $event)
    {
        $event->getDeliveryExcludeDate()->setActive(0);
        $event->getDeliveryExcludeDate()->save($event->getConnectionInterface());
    }

    /**
     * @param DateIsAvailableEvent $event
     */
    public function dateIsAvailable(DateIsAvailableEvent $event)
    {
        $liveDay = $event->getDate()->format('N');

        if (DeliveryExcludeDateCore::dayIsExclude($liveDay - 1)) {
            $event->setIsAvailable(false);
            return;
        }

        if (DeliveryExcludeDateQuery::create()
                ->filterByActive(true)
                ->filterByDate($event->getDate())
                ->findOne($event->getConnectionInterface()) !== null) {
            $event->setIsAvailable(false);
            return;
        }
    }

    /**
     * @param DatesIsAvailableEvent $event
     */
    public function datesIsAvailable(DatesIsAvailableEvent $event)
    {
        $deliveryExcludeDates = DeliveryExcludeDateQuery::create()
            ->filterByActive(true)
            ->filterByDate($event->getDates(), Criteria::IN)
            ->find($event->getConnectionInterface());

        /** @var \DateTime $date */
        foreach ($event->getDates() as $date) {
            $liveDay = $date->format('N');

            if (DeliveryExcludeDateCore::dayIsExclude($liveDay - 1)) {
                $event->setIsAvailable($date, false);
                return;
            }

            /** @var DeliveryExcludeDate $deliveryExcludeDate */
            foreach ($deliveryExcludeDates as $deliveryExcludeDate) {
                if ($deliveryExcludeDate->getDate()->getTimestamp() === $date->getTimestamp()) {
                    $event->setIsAvailable($date, false);
                    break;
                }
            }
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            DeliveryExcludeDateEvents::DELIVERY_EXCLUDE_DATE_CREATE => array("create", 128),
            DeliveryExcludeDateEvents::DELIVERY_EXCLUDE_DATE_UPDATE => array("update", 128),
            DeliveryExcludeDateEvents::DELIVERY_EXCLUDE_DATE_DELETE => array("delete", 128),
            DeliveryExcludeDateEvents::DELIVERY_EXCLUDE_DATE_ENABLE => array("enable", 128),
            DeliveryExcludeDateEvents::DELIVERY_EXCLUDE_DATE_DISABLE => array("disable", 128),
            DeliveryExcludeDateEvents::DATE_IS_AVAILABLE => array("dateIsAvailable", 128),
            DeliveryExcludeDateEvents::DATES_IS_AVAILABLE => array("datesIsAvailable", 128)
        );
    }
}
