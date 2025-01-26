<?php

declare(strict_types=1);

namespace App\Admin\Webshop;

use App\Enums\ProductStoreAction;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType};
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;

final class ProductStoreActivityAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->remove('batch')
            ->remove('delete')
            ->remove('edit')
        ;
    }
    
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('product')
            ->add('action',ChoiceType::class, [
                'choices' => ProductStoreAction::getItems()
            ])
            ->add('amount')
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('product')
            ->add('action')
            ->add('amount')
        ;
    }
    
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('product')
            ->add('action', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('amount')
        ;
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('product')
            ->add('action', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('amount')
        ;
    }
}