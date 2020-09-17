<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PublicationAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
			->add('title')
			->add('publisher')
            ->add('publicationEarliest')
            ->add('publicationLatest')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
			->add('title')
			->add('publisher')
            ->add('publicationEarliest')
            ->add('publicationLatest')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
			->add('title')
			->add('publisher', 'sonata_type_model', array('choices_as_values' => true, 'required' => false))
            ->add('publicationEarliest', 'date', array('years' => range(1820, date('Y'))))
            ->add('publicationLatest', 'date', array('years' => range(1820, date('Y'))))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
			->add('title')
			->add('publisher')
            ->add('publicationEarliest')
            ->add('publicationLatest')
        ;
    }
}
