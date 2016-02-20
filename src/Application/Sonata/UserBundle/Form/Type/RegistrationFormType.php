<?php

/*
 * User Bundle
 * This file is part of the BardisCMS.
 *
 * (c) George Bardis <george@bardis.info>
 *
 */

namespace Application\Sonata\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class RegistrationFormType extends AbstractType {

    private $campaignData;
    private $class;
    private $requestStack;

    /**
     * @param string $class The User class name
     * @param RequestStack $requestStack
     */
    public function __construct($class, RequestStack $requestStack)
    {
        $this->class = $class;
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $request = $this->requestStack->getMasterRequest();
        $REQUEST_URI = $request->server->get('REQUEST_URI');

        $this->campaignData = null;
        $this->campaignData = explode('/track-campaign/', $REQUEST_URI);
        $this->campaignData = end($this->campaignData);

        // Adding custom extra user fields for Registration Form
        $builder
            ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'SonataUserBundle'))
            ->add('username', TextType::class, array('label' => 'form.username', 'translation_domain' => 'SonataUserBundle'))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'SonataUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('firstname', TextType::class, array('label' => 'First Name*', 'required' => true))
            ->add('lastname', TextType::class, array('label' => 'Surname*', 'required' => true))
            ->add('campaign', HiddenType::class, array('label' => 'Campaign Name', 'data' => $this->campaignData, 'required' => false))
            ->add('termsAccepted', CheckboxType::class, array('label' => 'I accept the T&Cs*', 'required' => true));
            // Create user with no username and password (pre set email as both)
            //->remove('username')
            //->remove('plainPassword')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'registration',
        ));
    }

    public function getName() {
        return $this->getBlockPrefix();
    }

    // Define the name of the form to call it for rendering
    public function getBlockPrefix() {
        return 'sonata_user_custom_user_registration';
    }

    public function getExtendedType()
    {
        return method_exists(AbstractType::class, 'getBlockPrefix') ? FormType::class : 'form';
    }
}
