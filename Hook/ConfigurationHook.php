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

namespace DeliveryExcludeDate\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Class DeliveryExcludeDateHook
 * @package DeliveryExcludeDate\Hook
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class ConfigurationHook extends BaseHook
{
    /**
     * @param HookRenderEvent $event
     */
    public function onConfigurationShippingTop(HookRenderEvent $event)
    {
        $event->add($this->render(
            'delivery-exclude-date/hook/configuration-shipping.html'
        ));
    }
}
