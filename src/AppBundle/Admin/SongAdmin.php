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
			->add('releaseDate')
			->add('publications')
			->add('persons')
			->add('recordings')
			->add('tonality')
			->add('scorings')
			->add('genres')
			->add('tessitura')
			->add('langs', null, array('label' => 'Languages'))
			->add('poems')
			->add('premiere')
			->add('repositorys', null, array('label' => 'Repositories'))
			->add('catalogueLink')
			->add('spotifyLink')
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
			->add('releaseDate')
			->add('publications')
			->add('persons')
			->add('recordings')
			->add('tonality')
			->add('scorings')
			->add('genres')
			->add('tessitura')
			->add('langs', null, array('label' => 'Languages'))
			->add('poems')
			->add('premiere')
			->add('repositorys', null, array('label' => 'Repositories'))
			->add('catalogueLink')
			->add('spotifyLink')
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
			->add('compositionEarliest', null, array('years' => range(1821, date('Y'))))
			->add('compositionLatest', null, array('years' => range(1821, date('Y'))))
			->add('releaseDate', null, array('years' => range(1821, date('Y'))))

		#->add('publications', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
			->add('publications', null, array('by_reference' => false))

		#->add('persons', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
			->add('persons', null, array('by_reference' => false))

		#->add('recordings', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
			->add('recordings', null, array('by_reference' => false))

		#->add('tonality', 'sonata_type_model', array('choices_as_values' => true, 'required' => false))
			->add('tonality')

		#->add('scorings', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true))
			->add('scorings', null, array('by_reference' => false))

			->add('genres', null, array('by_reference' => false))

		#->add('tessitura', 'sonata_type_model', array('choices_as_values' => true, 'required' => false))
			->add('tessitura')

		#->add('langs', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true, 'label' => 'Languages'))
			->add('langs', null, array('by_reference' => false))

			->add('poems', null, array('by_reference' => false))
			->add('premiere')

		#->add('repositorys', 'sonata_type_model', array('choices_as_values' => true, 'required' => false, 'expanded' => false, 'multiple' => true, 'by_reference' => false, 'cascade_validation' => true, 'label' => 'Repositories'))
			->add('repositorys', null, array('by_reference' => false))
			->add('catalogueLink')
			->add('spotifyLink')

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
			->add('releaseDate')
			->add('publications')
			->add('persons')
			->add('recordings')
			->add('tonality')
			->add('scorings')
			->add('genres')
			->add('tessitura')
			->add('langs', null, array('label' => 'Languages'))
			->add('poems')
			->add('premiere')
			->add('repositorys', null, array('label' => 'Repositories'))
			->add('catalogueLink')
			->add('spotifyLink')
			->add('notes')
		;
	}
}
