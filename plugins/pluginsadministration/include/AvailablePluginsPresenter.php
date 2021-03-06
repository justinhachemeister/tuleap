<?php
/**
 * Copyright (c) Enalean, 2016. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

namespace Tuleap\PluginsAdministration;

class AvailablePluginsPresenter
{
    public $plugins;
    public $title;
    public $installed_tab_label;
    public $not_installed_tab_label;
    public $not_installed_pane_label;
    public $plugin_table_head;
    public $version_table_head;
    public $description_table_head;
    public $install_label;
    public $filter_label;
    public $no_local_plugins;
    public $filter_empty_state;
    /**
     * @var \CSRFSynchronizerToken
     */
    public $csrf_token;

    public function __construct(array $plugins, \CSRFSynchronizerToken $csrf_token)
    {
        $this->plugins                  = $plugins;
        $this->title                    = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'title');
        $this->installed_tab_label      = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'installed_tab_label');
        $this->not_installed_tab_label  = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'not_installed_tab_label');
        $this->not_installed_pane_label = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'not_installed_pane_label');
        $this->plugin_table_head        = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'plugin_table_head');
        $this->version_table_head       = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'version_table_head');
        $this->description_table_head   = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'description_table_head');
        $this->install_label            = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'install_label');
        $this->install_modal_title      = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'install_modal_title');
        $this->install_modal_content    = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'install_modal_content');
        $this->error_install_dependency = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'error_install_dependency');
        $this->install_modal_submit     = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'install_modal_submit');
        $this->install_modal_cancel     = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'install_modal_cancel');
        $this->filter_label             = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'filter_label');
        $this->no_local_plugins         = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'no_local_plugins');
        $this->filter_empty_state       = $GLOBALS['Language']->getText('plugin_pluginsadministration', 'filter_empty_state');

        $this->sortPlugins();
        $this->csrf_token = $csrf_token;
    }

    private function sortPlugins()
    {
        usort($this->plugins, function ($a, $b) {
            return strnatcasecmp($a['full_name'], $b['full_name']);
        });
    }
}
