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

namespace DeliveryExcludeDate;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Module\BaseModule;
use Thelia\Install\Database;

/**
 * Class DeliveryExcludeDate
 * @package DeliveryExcludeDate
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DeliveryExcludeDate extends BaseModule
{
    const MODULE_DOMAIN = 'deliveryexcludedate';

    /** @var array cache config */
    static private $cacheExcludeDay = array();

    /** @var array */
    static public $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');

    /**
     * @param ConnectionInterface $con
     */
    public function postActivation(ConnectionInterface $con = null)
    {
        if (!self::getConfigValue('is_initialized', false)) {
            $database = new Database($con);
            $database->insertSql(null, [__DIR__ . "/Config/thelia.sql", __DIR__ . "/Config/insert.sql"]);

            self::setConfigValue('exclude-monday', false);
            self::setConfigValue('exclude-tuesday', false);
            self::setConfigValue('exclude-wednesday', false);
            self::setConfigValue('exclude-thursday', false);
            self::setConfigValue('exclude-friday', false);
            self::setConfigValue('exclude-saturday', true);
            self::setConfigValue('exclude-sunday', true);

            self::setConfigValue('is_initialized', true);
        }
    }

    /**
     * @return array
     */
    public function getHooks()
    {
        return array(
            array(
                "type" => TemplateDefinition::BACK_OFFICE,
                "code" => "delivery-exclude-date.form-top",
                "title" => array(
                    "fr_FR" => "Module Feature Type, form haut",
                    "en_US" => "Module Feature Type, form top",
                ),
                "description" => array(
                    "fr_FR" => "En haut du formulaire de création et de mise à jour",
                    "en_US" => "Top of creation form and update",
                ),
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::BACK_OFFICE,
                "code" => "delivery-exclude-date.form-bottom",
                "title" => array(
                    "fr_FR" => "Module Feature Type, form bas",
                    "en_US" => "Module Feature Type, form bottom",
                ),
                "description" => array(
                    "fr_FR" => "En bas du formulaire de création et de mise à jour",
                    "en_US" => "Top of creation form and update",
                ),
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::BACK_OFFICE,
                "code" => "delivery-exclude-date.configuration-top",
                "title" => array(
                    "fr_FR" => "Module Feature Type, configuration haut",
                    "en_US" => "Module Feature Type, configuration top",
                ),
                "description" => array(
                    "fr_FR" => "En haut du la page de configuration du module",
                    "en_US" => "At the top of the module's configuration page",
                ),
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::BACK_OFFICE,
                "code" => "delivery-exclude-date.configuration-bottom",
                "title" => array(
                    "fr_FR" => "Module Feature Type, configuration bas",
                    "en_US" => "Module Feature Type, configuration bottom",
                ),
                "description" => array(
                    "fr_FR" => "En bas du la page de configuration du module",
                    "en_US" => "At the bottom of the module's configuration page",
                ),
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::BACK_OFFICE,
                "code" => "delivery-exclude-date.list-action",
                "title" => array(
                    "fr_FR" => "Module Feature Type, list action",
                    "en_US" => "Module Feature Type, list action",
                ),
                "description" => array(
                    "fr_FR" => "Action de la liste des dates",
                    "en_US" => "Action from the list of dates",
                ),
                "active" => true
            ),
            array(
                "type" => TemplateDefinition::BACK_OFFICE,
                "code" => "delivery-exclude-date.configuration-js",
                "title" => array(
                    "fr_FR" => "Module Feature Type, configuration js",
                    "en_US" => "Module Feature Type, configuration js",
                ),
                "description" => array(
                    "fr_FR" => "JS la page de configuration du module",
                    "en_US" => "JS of the module's configuration page",
                ),
                "active" => true
            )
        );
    }

    /**
     * @param int $day 0 => monday, 1 => tuesday ... 6 => sunday
     * @return bool
     */
    public static function dayIsExclude($day)
    {
        if (!count(self::$cacheExcludeDay)) {
            self::$cacheExcludeDay['monday'] = self::getConfigValue('exclude-monday', false);
            self::$cacheExcludeDay['tuesday'] = self::getConfigValue('exclude-tuesday', false);
            self::$cacheExcludeDay['wednesday'] = self::getConfigValue('exclude-wednesday', false);
            self::$cacheExcludeDay['thursday'] = self::getConfigValue('exclude-thursday', false);
            self::$cacheExcludeDay['friday'] = self::getConfigValue('exclude-friday', false);
            self::$cacheExcludeDay['saturday'] = self::getConfigValue('exclude-saturday', false);
            self::$cacheExcludeDay['sunday'] = self::getConfigValue('exclude-sunday', false);
        }

        return self::$cacheExcludeDay[self::$days[$day]];
    }
}
