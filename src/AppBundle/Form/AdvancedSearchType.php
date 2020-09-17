<?php

namespace AppBundle\Form;

use AppBundle\Entity\DboDocuments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
#use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use AppBundle\Search\Params;

class AdvancedSearchType extends AbstractType
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

            // Document Properties

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

            ->add('documentType', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'Document Type',
                #'choices' => $this->getDocumentTypes($em->getRepository('AppBundle:DboDocuments'))
            ))

  

            ->add('waxCountStart', 'integer', array(
                'attr' => array('min' => 0, 'max' => 12),
                'mapped' => false,
                'required' => false,
                'label' => 'Wax Count From'
            ))
            ->add('waxCountEnd', 'integer', array(
                'attr' => array('min' => 0, 'max' => 12),
                'mapped' => false,
                'required' => false,
                'label' => 'Wax Count To'
            ))



            ->add('impressionCountStart', 'integer', array(
                'attr' => array('min' => 0, 'max' => 12),
                'mapped' => false,
                'required' => false,
                'label' => 'Impression Count From'
            ))
            ->add('impressionCountEnd', 'integer', array(
                'attr' => array('min' => 0, 'max' => 12),
                'mapped' => false,
                'required' => false,
                'label' => 'Impression Count To'
            ))



            ->add('printCountStart', 'integer', array(
                'attr' => array('min' => 0, 'max' => 12),
                'mapped' => false,
                'required' => false,
                'label' => 'Print Count From'
            ))
            ->add('printCountEnd', 'integer', array(
                'attr' => array('min' => 0, 'max' => 12),
                'mapped' => false,
                'required' => false,
                'label' => 'Print Count To'
            ))



            // Wax Properties

            ->add('waxAttachmentSideES', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'Attachment Side',
                #'choices' => $this->getWaxAttachmentSides($em->getRepository('AppBundle:Wax'))
            ))

            ->add('waxAttachmentTypeES', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'Attachment Type',
                #'choices' => $this->getWaxAttachmentTypes($em->getRepository('AppBundle:Wax'))
            ))

            ->add('waxColourES', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'Wax Colour',
                #'choices' => $this->getWaxColours($em->getRepository('AppBundle:Wax'))
            ))

            ->add('waxConditionES', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'Wax Condition',
                #'choices' => $this->getWaxConditions($em->getRepository('AppBundle:Wax'))
            ))

            ->add('wasHasImprintsES', CheckboxType::class, array(
                'required' => false,
                'mapped' => false,
                'label' => 'Contains Imprint?'
            ))

            // Impression Properties

            ->add('widthStart', 'integer', array(
                'attr' => array('min' => 1, 'max' => 300),
                'mapped' => false,
                'required' => false,
                'label' => 'width From (mm)'
            ))
            ->add('widthEnd', 'integer', array(
                'attr' => array('min' => 1, 'max' => 300),
                'mapped' => false,
                'required' => false,
                'label' => 'Width To (mm)'
            ))

            ->add('heightStart', 'integer', array(
                'attr' => array('min' => 1, 'max' => 300),
                'mapped' => false,
                'required' => false,
                'label' => 'height From (mm)'
            ))
            ->add('heightEnd', 'integer', array(
                'attr' => array('min' => 1, 'max' => 300),
                'mapped' => false,
                'required' => false,
                'label' => 'height To (mm)'
            ))

            ->add('impressionConditionES', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'Impression Condition',
                #'choices' => $this->getImpressionConditions($em->getRepository('AppBundle:DboSealImpressions'))
            ))

            ->add('impressionShapeES', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'Impression Shape',
                #'choices' => $this->getImpressionShapes($em->getRepository('AppBundle:DboSealImpressions'))
            ))

            ->add('impressionPeopleES', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'People',
                #'choices' => $this->getImpressionMatrixPeople($em->getRepository('AppBundle:DboSealImpressions'))
            ))

            ->add('impressionPersonTypeES', ChoiceType::class, array(
                'expanded' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'label' => 'Person Type',
                #'choices' => $this->getImpressionMatrixPersonTypes($em->getRepository('AppBundle:DboSealImpressions'))
	    ))

	    ->add('matchingimpressions', 'checkbox', array(
		'label'    => 'Has matching impressions',
		'label_attr' => array(
                    'style' => 'font-weight:bold;',
                ),
	        'required' => false,
		))
	
	    ->add('matchingprints', 'checkbox', array(
		'label'    => 'Has matching prints',
		'label_attr' => array(
                    'style' => 'font-weight:bold;',
                ),

	        'required' => false,
	    ))
 
	    ->add('getGoodprint', 'checkbox', array(
		'label'    => 'Has good prints',
		'label_attr' => array(
                    'style' => 'font-weight:bold;',
                ),

	        'required' => false,
	    ))
	    
	    ->add('getPartialprint', 'checkbox', array(
		'label'    => 'Has partial prints',
		'label_attr' => array(
                    'style' => 'font-weight:bold;',
                ),
	        'required' => false,
	    ))

            // Buttons
            
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

    public function getDocumentTypes($em) {
        $results = $em->getDocumentTypes();
        $choices = array();
        foreach($results as $res) {
            $choices[$res['variabdoctype']] = $res['variabdoctype'];
        }
        return $choices;
    }

    public function getWaxAttachmentSides($em) {
        $results = $em->getWaxAttachmentSides();
        $choices = array();
        foreach($results as $res) {
            $choices[$res['term']] = $res['term'];
        }
        return $choices;
    }

    public function getWaxAttachmentTypes($em) {
        $results = $em->getWaxAttachmentTypes();
        $choices = array();
        foreach($results as $res) {
            $choices[$res['variabattachment']] = $res['variabattachment'];
        }
        return $choices;
    }

    public function getWaxColours($em) {
        $results = $em->getWaxColours();
        $choices = array();
        foreach($results as $res) {
            $choices[$res['variabcolour']] = $res['variabcolour'];
        }
        return $choices;
    }

    public function getWaxConditions($em) {
        $results = $em->getWaxConditions();
        $choices = array();
        foreach($results as $res) {
            $choices[$res['variabcondition']] = $res['variabcondition'];
        }
        return $choices;
    }

    public function getImpressionConditions($em) {
        $results = $em->getImpressionConditions();
        $choices = array();
        foreach($results as $res) {
            $choices[$res['variabcondition']] = $res['variabcondition'];
        }
        return $choices;
    }

    public function getImpressionShapes($em) {
        $results = $em->getImpressionShapes();
        $choices = array();
        foreach($results as $res) {
            $choices[$res['variabshape']] = $res['variabshape'];
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

    public function getImpressionMatrixPersonTypes($em) {
        $results = $em->getImpressionMatrixPersonTypes();
        $choices = array();
        foreach($results as $res) {
            $choices[$res['variabgender']] = $res['variabgender'];
        }
        return $choices;
    }
}
