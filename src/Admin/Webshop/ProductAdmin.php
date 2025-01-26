<?php

declare(strict_types=1);

namespace App\Admin\Webshop;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


final class ProductAdmin extends AbstractAdmin
{
    
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name')
            ->add('productNumber')
            ->add('description')
            ->add('category')
            ->add('price')
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('name')
            ->add('productNumber')
            ->add('description')
            ->add('category')
            ->add('price')
            ->add('actualStockAmount')
        ;
    }
    
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('productNumber')
            ->add('name')
            ->add('description')
            ->add('category')
            ->add('price')
            ->add('actualStockAmount')
        ;
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('name')
            ->add('productNumber')
            ->add('description')
            ->add('category')
            ->add('price')
            ->add('actualStockAmount')
        ;
    }
    
}