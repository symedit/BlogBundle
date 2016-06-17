<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Settings;

use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;

class BlogSettingsSchema implements SchemaInterface
{
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('max_posts', 'integer', [
                'label' => 'symedit.settings.blog.max_posts',
            ])
        ;
    }

    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults([
                'max_posts' => 3,
            ])
        ;
    }
}
