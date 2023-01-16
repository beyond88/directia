<?php

namespace Root\Directia\Admin;

class PluginMeta
{

    public function __construct()
    {

        add_filter( 'plugin_action_links_' . DIRECTIA_BASENAME, [$this, 'pluginActionLinks'] );
        add_filter('plugin_row_meta', [$this, 'pluginMetaLinks'], 10, 2);

    }

    public function pluginActionLinks( $links ) {

        $links[] = '<a href="' . admin_url( 'admin.php?page=directia' ) . '">' . __( 'Settings', 'directia' ) . '</a>';
		$links[] = '<a href="#">' . __( 'Docs', 'directia' ) . '</a>';
        return $links;

    }

    public function pluginMetaLinks( $links, $file ){
        
        if ($file !== plugin_basename( DIRECTIA_FILE )) {
			return $links;
		}

		$support_link = '<a target="_blank" href="https://github.com/beyond88/directia" title="' . __('Get help', 'directia') . '">' . __('Support', 'directia') . '</a>';
		$home_link = '<a target="_blank" href="https://github.com/beyond88/directia" title="' . __('Plugin Homepage', 'directia') . '">' . __('Plugin Homepage', 'directia') . '</a>';
		$rate_link = '<a target="_blank" href="https://github.com/beyond88/directia" title="' . __('Rate the plugin', 'directia') . '">' . __('Rate the plugin ★★★★★', 'directia') . '</a>';

		$links[] = $support_link;
		$links[] = $home_link;
		$links[] = $rate_link;

		return $links;

    }
}