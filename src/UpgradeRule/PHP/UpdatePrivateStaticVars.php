<?php

namespace SilverStripe\Upgrader\UpgradeRule\PHP;

use PhpParser\NodeVisitor\NameResolver;
use SilverStripe\Upgrader\CodeCollection\CodeChangeSet;
use SilverStripe\Upgrader\CodeCollection\ItemInterface;
use SilverStripe\Upgrader\UpgradeRule\PHP\Visitor\ParentConnector;
use SilverStripe\Upgrader\UpgradeRule\PHP\Visitor\RenameClassesVisitor;
use SilverStripe\Upgrader\Util\MutableSource;

class UpdatePrivateStaticVars extends PHPUpgradeRule
{
    public function upgradeFile($contents, ItemInterface $file, CodeChangeSet $changeset)
    {
        if (!$this->appliesTo($file)) {
            return $contents;
        }

        $staticMethods = array(
            //dataobject (including pages)
            '$db',
            '$icon',
            '$has_one',
            '$has_many',
            '$many_many',
            '$belongs_many_many',
            '$many_many_extraFields',
            '$summary_fields',
            '$searchable_fields',
            '$default_sort',
            '$extensions',
            '$defaults',
            '$plural_name',
            '$singular_name',
            '$default_records',
            '$indexes',
            '$field_labels',
            //model admin
            '$menu_icon',
            '$title',
            '$menu_title',
            '$url_segment',
            '$managed_models',
            '$model_importers',
            //controllers
            '$url_handlers',
            '$allowed_actions'
        );

        foreach ($staticMethods as $searchVar) {
            if (stripos($contents, 'public static $') !== false) {
                $contents = str_replace("public static {$searchVar}", "private static {$searchVar}", $contents);
            }
        }

        return $contents;
    }
}
