<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Controller;

use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 */
class CategoryController extends ResourceController
{
    /**
     * Lists all Page entities.
     */
    public function indexAction(Request $request)
    {
        $rootCategory = $this->getRepository()->findRoot();

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Category/index.html.twig')
            ->setTemplateVar('root')
            ->setData($rootCategory);

        return $this->handleView($view);
    }

    /**
     * Get single resource by its identifier.
     */
    public function showAction()
    {
        $request = $this->getRequest();
        $slug = $request->get('slug');
        $config = $this->getConfiguration();
        $posts = $this->getRepository()->getPostsBySlugQueryBuilder($slug);

        $paginator = $this
            ->getRepository()
            ->getPaginator($posts)
            ->setMaxPerPage($config->getPaginationMaxPerPage())
            ->setCurrentPage($request->get('page', 1));

        $view = $this
            ->view()
            ->setTemplate($config->getTemplate('show.html'))
            ->setData(array(
                $config->getResourceName() => $this->findOr404(),
                'posts' => $paginator,
            ))
        ;

        return $this->handleView($view);
    }
}
