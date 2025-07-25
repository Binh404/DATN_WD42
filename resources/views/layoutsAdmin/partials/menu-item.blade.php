<?php
// resources/views/components/menu-item.blade.php
?>
@if($this->shouldRender())
<li class="nav-item">
    @if($hasSubmenu)
        <a class="nav-link" data-bs-toggle="collapse" href="#{{ $menuKey }}" aria-expanded="false" aria-controls="{{ $menuKey }}">
            <i class="menu-icon {{ $icon }}"></i>
            <span class="menu-title">{{ $title }}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="{{ $menuKey }}">
            <ul class="nav flex-column sub-menu">
                {{ $slot }}
            </ul>
        </div>
    @else
        <a class="nav-link" href="{{ $route ? route($route) : '#' }}">
            <i class="menu-icon {{ $icon }}"></i>
            <span class="menu-title">{{ $title }}</span>
        </a>
    @endif
</li>
@endif
