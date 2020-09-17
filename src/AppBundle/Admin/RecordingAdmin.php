<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RecordingAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
			->add('title')
			->add('songs')
            ->add('recordingEarliest')
            ->add('recordingLatest')
            ->add('publications')
            ->add('persons')
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
			->add('songs')
            ->add('recordingEarliest')
            ->add('recordingLatest')
            ->add('publications')
            ->add('persons')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
			->add('title')
			->add('songs')
            ->add('recordingEarliest', 'date', array('years' => range(1821, date('Y'))))
            ->add('recordingLatest', 'date', array('years' => range(1821, date('Y'))))
            ->add('publications', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
            ->add('persons', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
			->add('title')
			->add('songs')
            ->add('recordingEarliest')
            ->add('recordingLatest')
            ->add('publications')
            ->add('persons')
        ;
    }
}
