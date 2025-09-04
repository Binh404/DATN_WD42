<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Helpers\MenuHelper;

class MenuItemComponent extends Component
{
    public $menuKey;
    public $title;
    public $icon;
    public $route;
    public $hasSubmenu;

    public function __construct($menuKey, $title, $icon, $route = null, $hasSubmenu = false)
    {
        $this->menuKey = $menuKey;
        $this->title = $title;
        $this->icon = $icon;
        $this->route = $route;
        $this->hasSubmenu = $hasSubmenu;
    }

    public function render()
    {
        return view('admin.layoutsAdmin.partials.menu-item');
    }

    public function shouldRender()
    {
        return MenuHelper::hasMenuPermission($this->menuKey);
    }
}
