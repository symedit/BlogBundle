<?php

namespace SymEdit\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymEdit\Bundle\CoreBundle\DependencyInjection\SymEditResourceExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SymEditBlogExtension extends SymEditResourceExtension
{
    protected $configFiles = array(
        'services', 'form', 'widget',
    );

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configDir = __DIR__.'/../Resources/config';

        list($config) = $this->configure($config, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS);

        $container->setParameter('symedit_blog.model_manager_name', $config['model_manager_name']);

        if (isset($config['resources'])) {
            $this->createResourceServices($config['resources'], $container);
        }
    }

    public function getAlias()
    {
        return 'symedit_blog';
    }
}
