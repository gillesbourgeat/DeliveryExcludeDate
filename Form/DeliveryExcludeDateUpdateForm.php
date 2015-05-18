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

use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class DeliveryExcludeDateUpdateForm
 * @package DeliveryExcludeDate\Form
 * @author Gilles Bourgeat <gbourgeat@openstudio.fr>
 */
class DeliveryExcludeDateUpdateForm extends DeliveryExcludeDateCreateForm
{
    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return 'delivery_exclude_date-update';
    }

    /**
     *
     * in this function you add all the fields you need for your Form.
     * Form this you have to call add method on $this->formBuilder attribute :
     *
     */
    protected function buildForm()
    {
        parent::buildForm();

        $this->formBuilder
            ->add('id', 'integer', array(
                'required' => true,
                'constraints' => array(
                    new NotBlank()
                )
            ));
    }
}
