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
 * Class DatesIsAvailableEvent
 * @package DeliveryExcludeDate\Event\Base
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DatesIsAvailableEvent extends ActionEvent
{
    /** @var \DateTime[] */
    private $dates = array();

    /** @var bool[] */
    private $isAvailable = array();

    /** @var null|ConnectionInterface */
    private $connectionInterface = null;

    /**
     * @param \DateTime[] $dates
     */
    public function __construct(array $dates)
    {
        /** @var \DateTime $date */
        foreach ($dates as $date) {
            $this->addDate($date);
        }
    }

    /**
     * @return \DateTime[]
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @return $this
     */
    public function removeAll()
    {
        $this->dates = array();

        $this->isAvailable = array();

        return $this;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function addDate(\DateTime $date)
    {
        $this->dates[$date->getTimestamp()] = $date;

        $this->isAvailable[$date->getTimestamp()] = true;

        return $this;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function removeDate(\DateTime $date)
    {
        unset($this->dates[$date->getTimestamp()]);

        return $this;
    }

    /**
     * @param \DateTime $date
     * @param bool $isAvailable
     * @return $this
     */
    public function setIsAvailable(\DateTime $date, $isAvailable)
    {
        $this->isAvailable[$date->getTimestamp()] = boolval($isAvailable);

        return $this;
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    public function getIsAvailable(\DateTime $date)
    {
        if (isset($this->isAvailable[$date->getTimestamp()])) {
            return $this->isAvailable[$date->getTimestamp()];
        }

        return false;
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
