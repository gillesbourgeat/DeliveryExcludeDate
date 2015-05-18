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

namespace DeliveryExcludeDate\Smarty\Plugins;

use DeliveryExcludeDate\DeliveryExcludeDate;
use Symfony\Component\EventDispatcher\EventDispatcher;
use TheliaSmarty\Template\AbstractSmartyPlugin;
use TheliaSmarty\Template\SmartyPluginDescriptor;

/**
 * Class DeliveryExcludeDatePlugin
 * @package DeliveryExcludeDate\Smarty\Plugins
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DeliveryExcludeDatePlugin extends AbstractSmartyPlugin
{
    /** @var EventDispatcher */
    protected $dispatcher;

    /**
     * @param EventDispatcher $dispatcher
     */
    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return array of SmartyPluginDescriptor
     */
    public function getPluginDescriptors()
    {
        return array(
            new SmartyPluginDescriptor("function", "delivery_day_is_excluded", $this, "deliveryDayIsExcluded")
        );
    }

    /**
     * @param $params
     * @param $smarty
     * @return bool
     * @throws \Exception
     */
    public function deliveryDayIsExcluded($params, $smarty)
    {
        if (!isset($params['day'])) {
            throw new \Exception('param "day" not found');
        }

        if ((int) $params['day'] < 0 || (int) $params['day'] > 6) {
            throw new \Exception('param "day" not valid');
        }

        return DeliveryExcludeDate::dayIsExclude((int) $params['day']);
    }
}
