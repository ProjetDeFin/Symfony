<?php

namespace App\Controller\Admin;

use App\Entity\InternshipOffer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;

class InternshipOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InternshipOffer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title', 'Titre'),
            TextField::new('description', 'Description'),
            AssociationField::new('company', 'Entreprise'),
            DateField::new('startAt', 'Date de début'),
            DateField::new('endAt', 'Date de fin'),
            DateField::new('startApplyDate', 'Date de début des candidatures'),
            DateField::new('endApplyDate', 'Date de fin des candidatures'),
            ChoiceField::new('type', 'Type')->setChoices([
                'Stage' => 'INTERNSHIP',
                'Alternance' => 'APPRENTICESHIP',
            ]),
            CollectionField::new('missions', 'Missions')
                ->setEntryType(TextEditorType::class)
                ->setFormTypeOptions([
                    'entry_options' => ['label' => false],
                ])
                ->allowAdd()
                ->allowDelete()
                ->setCustomOption('entry.is_editable', true),
            CollectionField::new('desiredProfiles', 'Profils Recherchés')
                ->setEntryType(TextEditorType::class)
                ->setFormTypeOptions([
                    'entry_options' => ['label' => false],
                ])
                ->allowAdd()
                ->allowDelete()
                ->setCustomOption('entry.is_editable', true),
        ];
    }
}

