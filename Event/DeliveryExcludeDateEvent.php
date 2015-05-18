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

namespace DeliveryExcludeDate\Event;

use DeliveryExcludeDate\Model\DeliveryExcludeDate;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\Event\ActionEvent;

/**
 * Class DeliveryExcludeDateEvent
 * @package DeliveryExcludeDate\Event\Base
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DeliveryExcludeDateEvent extends ActionEvent
{
    /** @var DeliveryExcludeDate */
    private $deliveryExcludeDate = null;

    /** @var null|ConnectionInterface */
    private $connectionInterface = null;

    /**
     * @param DeliveryExcludeDate $deliveryExcludeDate
     */
    public function __construct(DeliveryExcludeDate $deliveryExcludeDate)
    {
        $this->setDeliveryExcludeDate($deliveryExcludeDate);
    }

    /**
     * @param DeliveryExcludeDate $deliveryExcludeDate
     * @return $this
     */
    public function setDeliveryExcludeDate(DeliveryExcludeDate $deliveryExcludeDate)
    {
        $this->deliveryExcludeDate = $deliveryExcludeDate;

        return $this;
    }

    /**
     * @return DeliveryExcludeDate
     */
    public function getDeliveryExcludeDate()
    {
        return $this->deliveryExcludeDate;
    }

    /**
     * @return null|ConnectionInterface
     */
    public function getConnectionInterface()
    {
        return $this->connectionInterface;
    }

    /**
     * @param ConnectionInterface $connectionInterface
     * @return $this
     */
    public function setConnectionInterface(ConnectionInterface $connectionInterface)
    {
        $this->connectionInterface = $connectionInterface;

        return $this;
    }
}
