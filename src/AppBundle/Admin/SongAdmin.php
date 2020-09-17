<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SongAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('compositionEarliest')
            ->add('compositionLatest')
            ->add('publications')
            ->add('persons')
            ->add('recordings')
            ->add('tonality')
            ->add('scorings')
            ->add('tessitura')
            ->add('langs', null, array('label' => 'Languages'))
            ->add('poems')
            ->add('premiere')
            ->add('repositorys', null, array('label' => 'Repositories'))
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
            ->add('compositionEarliest')
            ->add('compositionLatest')
            ->add('publications')
            ->add('persons')
            ->add('recordings')
            ->add('tonality')
            ->add('scorings')
            ->add('tessitura')
            ->add('langs', null, array('label' => 'Languages'))
            ->add('poems')
            ->add('premiere')
            ->add('repositorys', null, array('label' => 'Repositories'))
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
            ->add('compositionEarliest', 'date', array('years' => range(1821, date('Y'))))
            ->add('compositionLatest', 'date', array('years' => range(1821, date('Y'))))
            #->add('publications', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
            #->add('persons', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
            #->add('recordings', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
            ->add('tonality', 'sonata_type_model', array('choices_as_values' => true, 'required' => false))
            #->add('scorings', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
            ->add('tessitura', 'sonata_type_model', array('choices_as_values' => true, 'required' => false))
            #->add('langs', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true, 'label' => 'Languages'))
            ->add('poems', null, array('by_reference' => false))
            ->add('premiere')
            #->add('repositorys', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true, 'label' => 'Repositories'))
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
            ->add('compositionEarliest')
            ->add('compositionLatest')
            ->add('publications')
            ->add('persons')
            ->add('recordings')
            ->add('tonality')
            ->add('scorings')
            ->add('tessitura')
            ->add('langs', null, array('label' => 'Languages'))
            ->add('poems')
            ->add('premiere')
            ->add('repositorys', null, array('label' => 'Repositories'))
            ->add('notes')
        ;
    }
}
