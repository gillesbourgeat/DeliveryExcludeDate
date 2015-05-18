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

namespace DeliveryExcludeDate\Loop;

use DeliveryExcludeDate\Model\DeliveryExcludeDate;
use DeliveryExcludeDate\Model\DeliveryExcludeDateQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/**
 * Class DeliveryExcludeDateLoop
 * @package DeliveryExcludeDate\Loop
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DeliveryExcludeDateLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    /**
     * Definition of loop arguments
     *
     * example :
     *
     * public function getArgDefinitions()
     * {
     *  return new ArgumentCollection(
     *
     *       Argument::createIntListTypeArgument('id'),
     *           new Argument(
     *           'ref',
     *           new TypeCollection(
     *               new Type\AlphaNumStringListType()
     *           )
     *       ),
     *       Argument::createIntListTypeArgument('category'),
     *       Argument::createBooleanTypeArgument('new'),
     *       ...
     *   );
     * }
     *
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $query = new DeliveryExcludeDateQuery();

        /* manage translations */
        $this->configureI18nProcessing($query, array('TITLE', 'DESCRIPTION'));

        $query->orderByDate();

        return $query;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var DeliveryExcludeDate $entry */
        foreach ($loopResult->getResultDataCollection() as $entry) {
            $row = new LoopResultRow($entry);
            $row
                ->set("ID", $entry->getId())
                ->set("TITLE", $entry->getVirtualColumn('i18n_TITLE'))
                ->set("DESCRIPTION", $entry->getVirtualColumn('i18n_DESCRIPTION'))
                ->set("ACTIVE", $entry->getActive())
                ->set("DATE", $entry->getDate())
            ;
            $this->addMoreResults($row, $entry);
            $loopResult->addRow($row);
        }

        return $loopResult;
    }

    protected function addMoreResults(LoopResultRow $row, $entryObject)
    {
    }
}
