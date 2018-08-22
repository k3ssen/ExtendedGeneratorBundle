<?php
declare(strict_types=1);

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateTypeExtension extends AbstractTypeExtension
{
    public function getExtendedType(): string
    {
        return DateType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'widget' => 'single_text',
            'placeholder' => 'dd-mm-yyyy',
            'format' => 'dd-MM-yyyy', # http://symfony.com/doc/current/reference/forms/types/date.html#format
            'js-format' => 'dd-mm-yyyy' # format used in javascript: https://bootstrap-datepicker.readthedocs.io/en/latest/options.html#format
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        $attr = $view->vars['attr'] ?? [];
        if ($options['widget'] === 'single_text') {
            $attr = array_merge([
                'data-role' => 'datepicker',
                'data-date-format' => $options['js-format'],
            ], $attr);

            $attr['placeholder'] = is_array($options['placeholder']) ? array_pop($options['placeholder']) : $options['placeholder'];
        }
        $view->vars['attr'] = $attr;
    }
}