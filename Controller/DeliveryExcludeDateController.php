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

use DeliveryExcludeDate\Event\DeliveryExcludeDateEvent;
use DeliveryExcludeDate\Event\DeliveryExcludeDateEvents;
use DeliveryExcludeDate\Model\DeliveryExcludeDate;
use DeliveryExcludeDate\Model\DeliveryExcludeDateI18n;
use DeliveryExcludeDate\Model\DeliveryExcludeDateQuery;
use Symfony\Component\Form\Form;
use Thelia\Controller\Admin\BaseAdminController;
use DeliveryExcludeDate\DeliveryExcludeDate as DeliveryExcludeDateCore;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Translation\Translator;
use Thelia\Model\LangQuery;
use Thelia\Tools\DateTimeFormat;

/**
 * Class DeliveryExcludeDateController
 * @package DeliveryExcludeDate\Controller
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DeliveryExcludeDateController extends BaseAdminController
{
    protected $objectName = 'Delivery exclude date';

    /**
     * @return mixed|\Thelia\Core\HttpFoundation\Response
     */
    public function viewAllAction()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'DeliveryExcludeDate', AccessManager::VIEW)) {
            return $response;
        }

        return $this->render("delivery-exclude-date/configuration");
    }

    /**
     * @param int $id
     * @return mixed|\Thelia\Core\HttpFoundation\Response
     * @throws \Exception
     */
    public function viewAction($id)
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'DeliveryExcludeDate', AccessManager::VIEW)) {
            return $response;
        }

        $deliveryExcludeDate = $this->getDeliveryExcludeDate($id);

        $title = array();
        $description = array();

        /** @var DeliveryExcludeDateI18n $i18n */
        foreach ($deliveryExcludeDate->getDeliveryExcludeDateI18ns() as $i18n) {
            if (null !== $lang = LangQuery::create()->findOneByLocale($i18n->getLocale())) {
                $title[$lang->getId()] = $i18n->getTitle();
                $description[$lang->getId()] = $i18n->getDescription();
            }
        }

        $form = $this->createForm('delivery_exclude_date.update', 'form', array(
            'id' => $deliveryExcludeDate->getId(),
            'active' => $deliveryExcludeDate->getActive(),
            'date' => $deliveryExcludeDate->getDate()->format('Y-m-d'),
            'title' => $title,
            'description' => $description
        ))->setError(true);

        $this->getParserContext()->addForm($form);

        if ($this->getRequest()->isXmlHttpRequest()) {
            return $this->render("delivery-exclude-date/include/form-update");
        } else {
            return self::viewAllAction();
        }
    }

    /**
     * @return mixed|null|\Symfony\Component\HttpFoundation\Response|\Thelia\Core\HttpFoundation\Response
     */
    public function createAction()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'DeliveryExcludeDate', AccessManager::CREATE)) {
            return $response;
        }

        $form = $this->createForm('delivery_exclude_date.create');

        try {
            $this->dispatch(
                DeliveryExcludeDateEvents::DELIVERY_EXCLUDE_DATE_CREATE,
                new DeliveryExcludeDateEvent($this->hydrateDeliveryExcludeDateForm(
                    $this->validateForm($form, 'POST')
                ))
            );

            return $this->generateSuccessRedirect($form);
        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("%obj modification", array('%obj' => $this->objectName)),
                $e->getMessage(),
                $form
            );

            return self::viewAllAction();
        }
    }

    /**
     * @param int $id
     * @return mixed|null|\Symfony\Component\HttpFoundation\Response|\Thelia\Core\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'DeliveryExcludeDate', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm('delivery_exclude_date.update');

        try {
            $this->dispatch(
                DeliveryExcludeDateEvents::DELIVERY_EXCLUDE_DATE_UPDATE,
                new DeliveryExcludeDateEvent(
                    self::hydrateDeliveryExcludeDateForm(
                        $this->validateForm($form, 'POST'),
                        $id
                    )
                )
            );

            return $this->generateSuccessRedirect($form);

        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("%obj modification", array('%obj' => $this->objectName)),
                $e->getMessage(),
                $form
            );

            return self::viewAllAction();
        }
    }

    /**
     * @param int $id
     * @return mixed|null|\Symfony\Component\HttpFoundation\Response|\Thelia\Core\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $form = $this->createForm('delivery_exclude_date.delete');

        try {
            $this->validateForm($form, 'POST');

            $deliveryExcludeDate = $this->getDeliveryExcludeDate($id);

            $this->dispatch(
                DeliveryExcludeDateEvents::DELIVERY_EXCLUDE_DATE_DELETE,
                new DeliveryExcludeDateEvent($deliveryExcludeDate)
            );

            return $this->generateSuccessRedirect($form);

        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("%obj modification", array('%obj' => $this->objectName)),
                $e->getMessage(),
                $form
            );

            return self::viewAllAction();
        }
    }

    public function enableAction($id)
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'DeliveryExcludeDate', AccessManager::UPDATE)) {
            return $response;
        }

        $this->getDispatcher()->dispatch(
            DeliveryExcludeDateEvents::DELIVERY_EXCLUDE_DATE_ENABLE,
            new DeliveryExcludeDateEvent($this->getDeliveryExcludeDate($id))
        );
    }

    public function disableAction($id)
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'DeliveryExcludeDate', AccessManager::UPDATE)) {
            return $response;
        }

        $this->getDispatcher()->dispatch(
            DeliveryExcludeDateEvents::DELIVERY_EXCLUDE_DATE_DISABLE,
            new DeliveryExcludeDateEvent($this->getDeliveryExcludeDate($id))
        );
    }

    /**
     * @param int $id
     * @return array|\DeliveryExcludeDate\Model\DeliveryExcludeDate|mixed
     * @throws \Exception
     */
    private function getDeliveryExcludeDate($id)
    {
        if (null === $deliveryExcludeDate = DeliveryExcludeDateQuery::create()->findPk($id)) {
            throw new \Exception(Translator::getInstance()->trans(
                "Date not found",
                array(),
                DeliveryExcludeDateCore::MODULE_DOMAIN
            ));
        }

        return $deliveryExcludeDate;
    }

    /**
     * @param Form $form
     * @param null|int $id
     * @return array|DeliveryExcludeDate|mixed
     * @throws \Exception
     */
    private function hydrateDeliveryExcludeDateForm($form, $id = null)
    {
        $data = $form->getData();

        if ($id !== null) {
            $deliveryExcludeDate = $this->getDeliveryExcludeDate($id);
        } else {
            $deliveryExcludeDate = new DeliveryExcludeDate();
        }

        $deliveryExcludeDate
            ->setActive((isset($data['active']) && (int) $data['active']) ? 1 : 0)
            ->setDate(new \DateTime($data['date']));

        foreach ($data['title'] as $langId => $title) {
            $deliveryExcludeDate
                ->setLocale(LangQuery::create()->findPk($langId)->getLocale())
                ->setTitle($title)
                ->setDescription($data['description'][$langId]);
        }

        return $deliveryExcludeDate;
    }
}
