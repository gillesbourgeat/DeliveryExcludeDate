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

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\Event\ActionEvent;

/**
 * Class DateIsAvailableEvent
 * @package DeliveryExcludeDate\Event\Base
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DateIsAvailableEvent extends ActionEvent
{
    /** @var \DateTime */
    private $date = null;

    /** @var bool */
    private $isAvailable = true;

    /** @var null|ConnectionInterface */
    private $connectionInterface = null;

    /**
     * @param \DateTime $date
     */
    public function __construct(\DateTime $date)
    {
        $this->setDate($date);
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param bool $isAvailable
     * @return $this
     */
    public function setIsAvailable($isAvailable)
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsAvailable()
    {
        return $this->isAvailable;
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
