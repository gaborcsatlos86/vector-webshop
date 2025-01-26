<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\UserBundle\Admin\Model\UserAdmin as SonataUserAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Sonata\UserBundle\Form\Type\RolesMatrixType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class UserAdmin extends SonataUserAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('general', ['class' => 'col-md-4'])
                ->add('name')
                ->add('username')
                ->add('email')
                ->add('plainPassword', PasswordType::class, [
                    'required' => (!$this->hasSubject() || null === $this->getSubject()->getId()),
                ])
                ->add('enabled', null)
            ->end()
            ->with('roles', ['class' => 'col-md-4'])
                ->add('realRoles', RolesMatrixType::class, [
                    'label' => false,
                    'multiple' => true,
                    'required' => false,
                ])
            ->end()
            ->with('extra', ['class' => 'col-md-4'])
                ->add('address')
            ->end()
        ;
    }
    
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('name')
            ->add('address')
        ;
        parent::configureListFields($list);
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        parent::configureDatagridFilters($filter);
        $filter
            ->add('name')
            ->add('address')
        ;
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        parent::configureShowFields($show);
        $show
            ->add('name')
            ->add('address')
        ;
    }
}