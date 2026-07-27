<?php

declare(strict_types=1);
/**
 * @copyright Copyright 2026 lat9 (https://vinosdefrutastropicales.com)
 *
 * BOOTSTRAP v4.0.0
 */
namespace Zencart\Plugins\Admin\Bootstrap4;

use Zencart\Templates\TemplateSelect as TemplateSelect;

class BootstrapColors
{
    private \queryFactory $db;
    protected ?int $groupId;
    protected array $bootstrapTemplates;
    protected string $selectedTemplate;
    protected ?array $inheritedColorValues = null;
    protected ?array $childColorValues = null;
    protected ?array $baseColorValues = null;
    protected ?TemplateSelect $templateSelect = null;

    public function __construct()
    {
        if (!defined('IS_ADMIN_FLAG') || IS_ADMIN_FLAG !== true) {
            return;
        }

        global $db, $template_dir;
        $this->db = $db;

        $sqlGroup =
            "SELECT configuration_group_id
               FROM " . TABLE_CONFIGURATION_GROUP . "
              WHERE configuration_group_title = 'ZCA Bootstrap Colors'";
        $groupID = $this->db->Execute($sqlGroup, 1);
        $this->groupId = ($groupID->EOF) ? null : (int)$groupID->fields['configuration_group_id'];
        if ($this->groupId === null) {
            return;
        }

        $template_info = zen_get_catalog_template_directories();
        foreach ($template_info as $key => $info) {
            if (!$info['is_plugin_template'] || empty($info['manifest']['template']['isBootstrap'])) {
                unset($template_info[$key]);
                continue;
            }
        }
        $this->bootstrapTemplates = $template_info;

        $this->setSelectedTemplate();
    }

    /**
     * Returns the configuration_group_id associate with the Bootstrap Colors
     * configuration settings; null indicates that the configuration group doesn't
     * exist.
     *
     * @since BOOTSTRAP 4.0.0
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * Returns an associative arrey (keyed on the template's directory
     * name) containing Zen Cart's gathered information for all bootstrap
     * templates installed via the Plugin Manager.
     *
     * @since BOOTSTRAP 4.0.0
     */
    public function getBootstrapTemplates(): array
    {
        return $this->bootstrapTemplates;
    }

    /**
     * Returns the currently-selected template directory.
     *
     * @since BOOTSTRAP 4.0.0
     */
    public function getSelectedTemplate(): string
    {
        return $this->selectedTemplate;
    }

    /**
     * Updates the currently-selected template directory.
     *
     * Byproducts: Also sets the indication as to whether this is
     * a child template and, if so, initializes the child's inherited
     * colors' array.
     *
     * @since BOOTSTRAP 4.0.0
     */
    public function setSelectedTemplate(?string $template = null): string
    {
        global $template_dir;

        $selected_template = ($template === null) ? ($_SESSION['zca_colors_template'] ?? $template_dir) : $template;
        if (!in_array($selected_template, array_keys($this->bootstrapTemplates))) {
            $selected_template = array_keys($this->bootstrapTemplates)[0];
        }

        $this->selectedTemplate = $selected_template;
        $_SESSION['zca_colors_template'] = $selected_template;

        $this->setInheritedChildColors();

        return $this->selectedTemplate;
    }

    /**
     * Initializes a child-template's current and inherited colors.
     *
     * @since BOOTSTRAP 4.0.0
     */
    protected function setInheritedChildColors(): void
    {
        $this->inheritedColorValues = [];
        $this->childColorValues = [];
        if ($this->isChildTemplate() === true) {
            $this->childColorValues = $this->getTemplateSpecificColors($this->selectedTemplate);
            $this->inheritedColorValues = $this->getInheritedColors($this->selectedTemplate);
        }
    }

    /**
     * Returns a boolean value indicating whether/not the specified (or
     * currently-selected) template is a child.
     *
     * @since BOOTSTRAP 4.0.0
     */
    protected function isChildTemplate(?string $template = null): bool
    {
        $template ??= $this->selectedTemplate;
        return $this->getParentTemplate($template) !== 'template_default';
    }

    /**
     * Returns the specified template's parent template, using 'template_default'
     * if the template doesn't supply a parent/base.
     *
     * @since BOOTSTRAP 4.0.0
     */
    protected function getParentTemplate(string $template): string
    {
        return $this->bootstrapTemplates[$template]['manifest']['template']['baseTemplate'] ?? 'template_default';
    }

    /**
     * Returns the current value of a specified color-key (null if the key's
     * not found). The value returned depends on whether the currently-selected
     * template is a bootstrap child or parent.
     *
     * @since BOOTSTRAP 4.0.0
     */
    public function getCurrentColorValue(string $key): ?string
    {
        return $this->isChildTemplate() ? ($this->childColorValues[$key] ?? $this->inheritedColorValues[$key] ?? null) : ($this->getBaseColorValues()[$key] ?? null);
    }

    /**
     * Processes a CSV input to update the various colors, returning a
     * numerically-indexed array containing the number of successful and
     * failed updates.
     *
     * @since BOOTSTRAP 4.0.0
     */
    public function updateFromCsv(array $csv_input, string $logfile): array
    {
        $color_keys = $this->getColorKeys();

        $success_count = 0;
        $line_count = 0;
        $fail_count = 0;
        $template_specific_colors = [];
        foreach ($csv_input as $key => $value) {
            $line_count++;

            // -----
            // Ignore the header line.
            //
            if ($line_count === 1) {
                continue;
            }

            $key = zen_db_input($key);
            $value = zen_db_input($value);
            if ($this->isValidColorValue($value) === false) {
                $fail_count++;
                error_log("Error in line $line_count: Invalid color value ($value) for key ($key).\n", 3, $logfile);
                continue;
            }

            if (!in_array($key, $color_keys, true)) {
                $fail_count++;
                error_log("Error in line $line_count: No matching key ($key).\n", 3, $logfile);
                continue;
            }

            if ($this->isChildTemplate() === true) {
                if (($this->inheritedColorValues[$key] ?? -1) !== $value) {
                    $template_specific_colors[$key] = $value;
                }
                continue;
            }

            $this->db->Execute(
                "UPDATE " . TABLE_CONFIGURATION . "
                    SET configuration_value = '$value',
                        last_modified = now()
                  WHERE configuration_group_id = {$this->groupId}
                    AND configuration_key = '$key'
                  LIMIT 1"
            );
            if ($this->db->affectedRows() === 1) {
                $success_count++;
            } else {
                error_log("Error in line $line_count - no matching key $configuration_key\n", 3, $logfile);
                $fail_count++;
            }
        }

        if ($this->isChildTemplate() === true) {
            $this->updateTemplateSettings($template_specific_colors);
        }

        return [$success_count, $fail_count];
    }

    /**
     * Processes a form's submittal to update the various colors, returning a
     * numerically-indexed array containing the number of successful and
     * failed updates.
     *
     * @since BOOTSTRAP 4.0.0
     */
    public function updateFromForm(array $colors, array $original): array
    {
        $update_count = 0;
        $error_count = 0;
        $template_specific_colors = [];
        foreach ($colors as $cID => $color) {
            if ($this->isValidColorValue($color) === false) {
                $error_count++;
                continue;
            }

            $cID = (int)$cID;
            $color = zen_db_prepare_input($color);

            if ($this->isChildTemplate() === true) {
                $key = $this->getKeyFromCid($cID);
                if ($key === '') {
                    $error_count++;
                    continue;
                }
                if (($this->inheritedColorValues[$key] ?? -1) !== $color) {
                    $update_count++;
                    $template_specific_colors[$key] = $color;
                }
                continue;
            }

            // -----
            // No change, continue on ...
            //
            if (($original[$cID] ?? -1) === $color) {
                continue;
            }

            // -----
            // Otherwise, the color is updated and the updated-count incremented.
            //
            $this->db->Execute(
                "UPDATE " . TABLE_CONFIGURATION . "
                    SET configuration_value = '" . zen_db_input($color) . "',
                        last_modified = now()
                  WHERE configuration_id = $cID
                    AND configuration_group_id = {$this->groupId}
                  LIMIT 1"
            );
            if ($this->db->affectedRows() === 1) {
                $update_count++;
            } else {
                $error_count++;
            }
        }

        if ($this->isChildTemplate() === true) {
            $this->updateTemplateSettings($template_specific_colors);
        }

        return [$update_count, $error_count];
    }

    /**
     * Returns the configuration_key associated with the specified
     * configuration_id; an empty string is returned if the
     * configuration_id isn't found (or associated with the Bootstrap
     * Colors configuration-group).
     *
     * @since BOOTSTRAP 4.0.0
     */
    protected function getKeyFromCid(int $cID): string
    {
        $key_info = $this->db->Execute(
            "SELECT configuration_key
               FROM " . TABLE_CONFIGURATION . "
              WHERE configuration_id = $cID
                AND configuration_group_id = {$this->groupId}
              LIMIT 1"
        );
        return ($key_info->EOF) ? '' : $key_info->fields['configuration_key'];
    }

    /**
     * Validates either Hexadecimal (3, 4, 6, or 8 characters) or RGBA (including standard RGB) color codes.
     *
     * @since BOOTSTRAP 4.0.0
     */
    protected function isValidColorValue(string $color): bool
    {
        $pattern = '/^(?:#([a-f0-9]{3,4}){1,2}|rgba?\(\s*([0-9]{1,3}\s*,\s*){2}[0-9]{1,3}\s*(?:,\s*(?:0|1|0?\.\d+))?\s*\))$/i';
        return (bool)preg_match($pattern, $color);
    }

    /**
     * Retrieves the 'base' (i.e. stored in the database) color values. These are
     * the values recorded for the bootstrap parent template.
     *
     * @since BOOTSTRAP 4.0.0
     */
    protected function getBaseColorValues(): array
    {
        if (isset($this->baseColorValues)) {
            return $this->baseColorValues;
        }

        $this->baseColorValues = [];
        $colors = $this->db->Execute(
            "SELECT configuration_key, configuration_value
               FROM " . TABLE_CONFIGURATION . "
              WHERE configuration_group_id = {$this->groupId}"
        );
        foreach ($colors as $next_color) {
            $this->baseColorValues[$next_color['configuration_key']] = $next_color['configuration_value'];
        }
        return $this->baseColorValues;
    }

    /**
     * Retrieves the configuration keys for the color configuration
     * values; they're the array keys for the base color values.
     *
     * @since BOOTSTRAP 4.0.0
     */
    protected function getColorKeys(): array
    {
        return array_keys($this->getBaseColorValues());
    }

    /**
     * Retrieves the inherited colors for a selected template, checking the template's
     * parent(s) until the 'base' bootstrap template parent is located.
     *
     * @since BOOTSTRAP 4.0.0
     */
    protected function getInheritedColors(string $selected_template): array
    {
        $inherited_colors = [];
        $parent_template = $this->getParentTemplate($selected_template);
        while ($this->isChildTemplate($parent_template) === true) {
            $inherited_colors = array_merge($this->getTemplateSpecificColors($parent_template), $inherited_colors);
            $parent_template = $this->getParentTemplate($parent_template);
        }
        return array_merge($this->getBaseColorValues(), $inherited_colors);
    }

    /**
     * Retrieves the template-specific color settings for a selected template. Those values are
     * saved in the template's `template_settings` array (json_encoded), present in the template's
     * entry in the `template_settings` table ... for 'child' templates **ONLY**.
     *
     * @since BOOTSTRAP 4.0.0
     */
    protected function getTemplateSpecificColors(string $selected_template): array
    {
        if ($this->isChildTemplate($selected_template) === false) {
            return [];
        }

        $this->templateSelect ??= new TemplateSelect();
        $tpl_settings = $this->templateSelect->getTemplateSettings($selected_template);
        if ($tpl_settings === null) {
            return [];
        }

        // -----
        // The template's `$tpl_settings` array might have non-color settings and/or
        // invalid color values.
        //
        // Loop through the Bootstrap Color 'keys' and only gather settings' that
        // are valid color elements.
        //
        $template_specific_colors = [];
        foreach ($this->getColorKeys() as $key) {
            if (isset($tpl_settings[$key]) && $this->isValidColorValue((string)$tpl_settings[$key])) {
                $template_specific_colors[$key] = $tpl_settings[$key];
            }
        }
        return $template_specific_colors;
    }

    /**
     * Updates a child template's `template_settings` with any changes to
     * the child's colors.
     *
     * Once any previous color settings have been removed, the current child colors are created
     * as an array and merged into any existing `$tpl_settings` array that might be present
     * in that file.
     *
     * @since BOOTSTRAP 4.0.0
     */
    protected function updateTemplateSettings(array $template_specific_colors): void
    {
        // -----
        // Retrieve the current `template_settings` from the database.
        //
        $this->templateSelect ??= new TemplateSelect();
        $tpl_settings = $this->templateSelect->getTemplateSettings($this->selectedTemplate);
        if ($tpl_settings === null) {
            $tpl_settings = [];
        }

        // -----
        // Remove any of the Bootstrap Color settings from the current template settings,
        // merge the updated settings into the current array of settings and write the
        // values back to the database.
        //
        foreach ($this->getColorKeys() as $key) {
            unset($tpl_settings[$key]);
        }

        $tpl_settings = array_merge($tpl_settings, $template_specific_colors);
        $this->templateSelect->setTemplateSettings($this->selectedTemplate, $tpl_settings);
    }
}
