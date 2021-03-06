<?php

/*
 * This file is part of the PablodipAdminModuleBundle package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pablodip\AdminModuleBundle\Action;

use Pablodip\ModuleBundle\Action\BaseRouteAction;
use Pablodip\AdminModuleBundle\BatchAction\DeleteBatchAction;

/**
 * DeleteAction.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class DeleteAction extends BaseRouteAction
{
    /**
     * {@inheritdoc}
     */
    protected function defineConfiguration()
    {
        $this
            ->setRoute('delete', '/{id}', 'DELETE')
            ->setController(array($this, 'controller'))
        ;

        $this->getModule()->getAction('list')->getOption('model_actions')->add(array(
            'delete' => 'PablodipAdminModuleBundle::dataActions/delete.html.twig',
        ));
        $this->getModule()->getAction('batch')->getOption('batch_actions')->add(array(
            'delete' => new DeleteBatchAction('Delete'),
        ));
    }

    public function controller($id)
    {
        $model = $this->getMolino()->findOneById($this->getModuleOption('model_class'), $id);
        if (!$model) {
            throw $this->createNotFoundException();
        }

        $this->getMolino()->delete($model);

        return $this->redirect($this->generateModuleUrl('list'));
    }
}
