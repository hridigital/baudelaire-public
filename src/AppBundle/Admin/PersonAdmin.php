<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PersonAdmin extends Admin
{
	/**
	 * @param DatagridMapper $datagridMapper
	 */
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('given')
			->add('surname')
			->add('gender')
			->add('countrys', null, array('label' => 'Nationalities'))
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
			->add('given')
			->add('surname')
			->add('gender')
			->add('countrys', null, array('label' => 'Nationalities'))
			;
	}

	/**
	 * @param FormMapper $formMapper
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('given')
			->add('surname')
			->add('gender')
			#->add('countrys', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true, 'label' => 'Nationalities'))
			->add('countrys', null, array('by_reference' => false, 'label' => 'Nationalities'))

			;
	}

	/**
	 * @param ShowMapper $showMapper
	 */
	protected function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
			->add('given')
			->add('surname')
			->add('gender')
			->add('countrys', null, array('label' => 'Nationalities'))
			->add('songs')
			;
	}
}
