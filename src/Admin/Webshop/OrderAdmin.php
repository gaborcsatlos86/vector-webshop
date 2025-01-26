<?php

declare(strict_types=1);

namespace App\Admin\Webshop;

use App\Enums\OrderState;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\StringListFilter;
use Sonata\DoctrineORMAdminBundle\Filter\DateRangeFilter;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType};

final class OrderAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->remove('create')
            ->remove('batch')
            ->remove('delete')
        ;
    }
    
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('state',ChoiceType::class, [
                'choices' => OrderState::getItems()
            ])
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('user')
            ->add('createdAt', DateRangeFilter::class)
        ;
    }
    
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('user.username')
            ->add('address')
            ->add('state', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('sumPrice')
            ->add('createdAt', FieldDescriptionInterface::TYPE_DATE)
        ;
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('user.username')
            ->add('address')
            ->add('state', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('sumPrice')
            ->add('createdAt', FieldDescriptionInterface::TYPE_DATE)
            ->add('items')
        ;
    }
    
    protected function configureExportFields(): array
    {
        return ['user.username', 'address', 'state', 'sumPrice', 'createdAt'];
    }
}