<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PoemAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('english')
            ->add('position')
            ->add('compositionEarliest')
            ->add('compositionLatest')
            ->add('publications')
            ->add('metres')
            ->add('form')
            ->add('rhyme')
            ->add('themes')
            ->add('songs')
            ->add('notes')
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
            ->add('english')
            ->add('position')
            ->add('compositionEarliest')
            ->add('compositionLatest')
            ->add('publications')
            ->add('metres')
            ->add('form')
            ->add('rhyme')
            ->add('themes')
            ->add('songs')
            ->add('notes')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('english')
            ->add('position')
            ->add('compositionEarliest', 'date', array('years' => range(1821, 1867)))
            ->add('compositionLatest', 'date', array('years' => range(1821, 1867)))
            ->add('publications', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
            ->add('metres', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
            ->add('form', 'sonata_type_model', array('choices_as_values' => true, 'required' => false))
            ->add('rhyme', 'sonata_type_model', array('choices_as_values' => true, 'required' => false))
            ->add('themes', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
            ->add('songs')
            ->add('notes')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('english')
            ->add('position')
            ->add('compositionEarliest')
            ->add('compositionLatest')
            ->add('publications')
            ->add('metres')
            ->add('form')
            ->add('rhyme')
            ->add('themes')
            ->add('songs')
            ->add('notes')
        ;
    }
}
