<?php

namespace AppBundle\Form;

use AppBundle\Entity\DboDocuments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
#use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Search\Params;

class SearchType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        // ...

        $resolver->setRequired('entity_manager');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $options['entity_manager'];

        $builder

            ->add('keyword', null, array(
                'required' => false,
                'mapped' => false
             ))

            ->add('repository', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'Repository',
                #'choices' => $this->getRepositories($em->getRepository('AppBundle:DboDocuments'))
            ))

            ->add('accession_number', null, array(
                'required' => false,
                'mapped' => false,
                'label' => 'Accession number'
             ))

            ->add('yearStart', 'integer', array(
                'attr' => array('min' => 1100, 'max' => 1600),
                'mapped' => false,
                'required' => false,
                'label' => 'Start Year'
            ))
            ->add('yearEnd', 'integer', array(
                'attr' => array('min' => 1100, 'max' => 1600),
                'mapped' => false,
                'required' => false,
                'label' => 'End Year'
            ))

            ->add('impressionPeopleES', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'People',
                #'choices' => $this->getImpressionMatrixPeople($em->getRepository('AppBundle:DboSealImpressions'))
            ))

            ->add('resetForm', 'reset', array(
                'label' => 'Reset',
                'attr' => array(
                    'class' => 'btn btn-danger',
                ),
            ))
            ->add('search','submit', array(
                'label' => 'Search',
                'attr' => array(
                    'class' => 'pull-right btn btn-primary',
                ),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => Params::class,
            'allow_extra_fields' => true,
            'csrf_protection' => false
        ));
        $resolver->setRequired('entity_manager');
    }

    public function getName()
    {
        return '';
    }

    /** Populate Choice Methods **/

    public function getRepositories($em) {
        $results = $em->getRepositories();
        $choices = array();
        foreach($results as $res) {
            $choices[$res['variabrepository']] = $res['variabrepository'];
        }
        return $choices;
    }

    public function getImpressionMatrixPeople($em) {
        $choices = array();
        $results = $em->getImpressionMatrixPeople1();
        foreach($results as $res) {
            if (!empty($res['analysisowner1name'])) {
                $choices[$res['analysisowner1name']] = $res['analysisowner1name'];
            }
        }
        $results = $em->getImpressionMatrixPeople2();
        foreach($results as $res) {
            if (!empty($res['analysisowner2name'])) {
                $choices[$res['analysisowner2name']] = $res['analysisowner2name'];
            }
        }
        array_unique($choices, SORT_REGULAR);
        return $choices;
    }

}
