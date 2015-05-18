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

namespace DeliveryExcludeDate\Form;

use DeliveryExcludeDate\DeliveryExcludeDate;
use Symfony\Component\Validator\ExecutionContextInterface;
use Thelia\Core\Translation\Translator;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;

/**
 * Class DeliveryExcludeDateCreateForm
 * @package DeliveryExcludeDate\Form
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DeliveryExcludeDateCreateForm extends DeliveryExcludeDateForm
{
    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return 'delivery_exclude_date-create';
    }

    /**
     *
     * in this function you add all the fields you need for your Form.
     * Form this you have to call add method on $this->formBuilder attribute :
     *
     */
    protected function buildForm()
    {
        $this->formBuilder
            ->add('title', 'collection', array(
                'type' => 'text',
                'allow_add'    => true,
                'allow_delete' => true,
                'label' => Translator::getInstance()->trans('Title'),
                'label_attr' => array(
                    'for' => 'title'
                ),
                'options' => array(
                    'required' => true
                )
            ))
            ->add('description', 'collection', array(
                'type' => 'text',
                'allow_add'    => true,
                'allow_delete' => true,
                'label_attr' => array(
                    'for' => 'description'
                ),
                'label' => Translator::getInstance()->trans('Description'),
                'options' => array(
                    'required' => true
                )
            ))
            ->add('active', 'text', array(
                'required' => false,
                'empty_data' => false,
                'label' => Translator::getInstance()->trans('Active', array(), DeliveryExcludeDate::MODULE_DOMAIN),
                'label_attr' => array(
                    'for' => 'active'
                )
            ))
            ->add('date', 'text', array(
                'required' => true,
                'label' => Translator::getInstance()->trans('Date'),
                'constraints' => array(
                    new NotBlank(),
                    new Callback(array(
                        "methods" => array(
                            array($this,
                                "checkDate"),
                        )
                    ))
                ),
                'label_attr' => array(
                    'for' => 'date'
                )
            ));
    }

    /**
     * @param $value
     * @param ExecutionContextInterface $context
     */
    public function checkDate($value, ExecutionContextInterface $context)
    {
        if (!\DateTime::createFromFormat('Y-m-d', $value)) {
            $context->addViolation(Translator::getInstance()->trans(Translator::getInstance()->trans(
                "This date is not valid",
                array(),
                DeliveryExcludeDate::MODULE_DOMAIN
            )));
        }
    }
}
