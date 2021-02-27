<?php

declare(strict_types=1);

/*
 * This file is part of the Picterest source code.
 *
 * (c) Julien Broyard <broyard.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Pin;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PinCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pin::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->disable(ACTION::EDIT, ACTION::NEW);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Pin')
            ->setEntityLabelInPlural('Pins')
            ->setSearchFields(['author', 'createdAt', 'title'])
            ->setDefaultSort(['createdAt' => 'DESC'])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('author');
        yield TextField::new('title');
        yield TextEditorField::new('description');

        yield ImageField::new('imageName')
            ->setBasePath('/uploads/images')
            ->setLabel('Image')
        ;

        yield DateTimeField::new('createdAt')->setFormTypeOptions([
            'html5' => true,
            'widget' => 'single_text',
            'years' => range(date('Y'), date('Y') + 5),
        ]);

        yield DateTimeField::new('updatedAt')->setFormTypeOptions([
            'html5' => true,
            'widget' => 'single_text',
            'years' => range(date('Y'), date('Y') + 5),
        ]);
    }
}
