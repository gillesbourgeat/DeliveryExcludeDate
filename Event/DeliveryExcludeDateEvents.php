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

/**
 * Class DeliveryExcludeDateEvents
 * @package DeliveryExcludeDate\Event
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DeliveryExcludeDateEvents
{
    const DELIVERY_EXCLUDE_DATE_CREATE = 'action.delivery_exclude_date.create';
    const DELIVERY_EXCLUDE_DATE_UPDATE = 'action.delivery_exclude_date.update';
    const DELIVERY_EXCLUDE_DATE_DELETE = 'action.delivery_exclude_date.delete';
    const DELIVERY_EXCLUDE_DATE_ENABLE = 'action.delivery_exclude_date.enable';
    const DELIVERY_EXCLUDE_DATE_DISABLE = 'action.delivery_exclude_date.disable';
    const DATE_IS_AVAILABLE = 'action.delivery_exclude_date.date_is_available';
    const DATES_IS_AVAILABLE = 'action.delivery_exclude_date.dates_is_available';
}
