<?php

namespace SilverStripe\Upgrader\UpgradeRule\SS;

use SilverStripe\Upgrader\CodeCollection\CodeChangeSet;
use SilverStripe\Upgrader\CodeCollection\ItemInterface;

/**
 * Renames template locale keys
 */
class RenameTemplateSyntax extends TemplateUpgradeRule
{
    /**
     * Upgrades the contents of the given file
     * Returns string containing the new code.
     *
     * @param string $contents
     * @param ItemInterface $file
     * @param \SilverStripe\Upgrader\CodeCollection\CodeChangeSet $changeset Changeset to add warnings to
     * @return string
     */
    public function upgradeFile($contents, ItemInterface $file, CodeChangeSet $changeset)
    {
        if (!$this->appliesTo($file)) {
            return $contents;
        }

        $searches = [
            '<% control',
            '<% end_control %>'
        ];

        $replacements = [
            '<% loop',
            '<% end_loop %>'
        ];

        return str_replace($searches, $replacements, $contents);
    }
}
