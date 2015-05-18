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

namespace DeliveryExcludeDate\Controller;

use Thelia\Controller\Admin\BaseAdminController;
use DeliveryExcludeDate\DeliveryExcludeDate as DeliveryExcludeDateCore;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Model\ModuleConfigQuery;
use Thelia\Model\ModuleQuery;

/**
 * Class DeliveryExcludeDateDayController
 * @package DeliveryExcludeDate\Controller
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DeliveryExcludeDateDayController extends BaseAdminController
{
    protected $objectName = 'Delivery exclude date';

    /**
     * @param int $day 0 => monday, 1 => tuesday ... 6 => sunday
     * @return mixed
     */
    public function enableAction($day)
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'DeliveryExcludeDate', AccessManager::UPDATE)) {
            return $response;
        }

        self::toggle($day, true);
    }

    /**
     * @param int $day 0 => monday, 1 => tuesday ... 6 => sunday
     * @return mixed
     */
    public function disableAction($day)
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'DeliveryExcludeDate', AccessManager::UPDATE)) {
            return $response;
        }

        self::toggle($day, false);
    }

    /**
     * @param int $day 0 => monday, 1 => tuesday ... 6 => sunday
     * @param boolean $value
     */
    private function toggle($day, $value)
    {
        ModuleConfigQuery::create()
            ->setConfigValue(
                ModuleQuery::create()->findOneByCode('DeliveryExcludeDate')->getId(),
                "exclude-" . DeliveryExcludeDateCore::$days[$day],
                $value
            );
    }
}
