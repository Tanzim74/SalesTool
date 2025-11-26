<div class="side-content-wrap">
    <!-- Main Sidebar -->
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <!-- Dashboard -->
            <li class="nav-item" data-item="dashboard">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>

             <li class="nav-item" data-item="modules">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Modules</span>
                </a>
                <div class="triangle"></div>
            </li>

            <!-- Users -->
            <li class="nav-item" data-item="users">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Administrator"></i>
                    <span class="nav-text">Users</span>
                </a>
                <div class="triangle"></div>
            </li>

            <!-- Settings -->
            <li class="nav-item" data-item="settings">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Gear-2"></i>
                    <span class="nav-text">Settings</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>

    <!-- Secondary Sidebar (Submenus) -->
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <!-- Dashboard Submenu -->
        <ul class="childNav" data-parent="dashboard">
            <li class="nav-item">
                <a href="/dashboards/admin">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">Admin Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboards/analytics">
                    <i class="nav-icon i-Analytics-2"></i>
                    <span class="item-name">Analytics</span>
                </a>
            </li>
        </ul>

        <ul class="childNav" data-parent="modules">
            <li class="nav-item">
                <a href="/modules/reading">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">Reading</span>
                </a>
            </li>
           
        </ul>



        <!-- Users Submenu -->
        <ul class="childNav" data-parent="users">
            <li class="nav-item">
                <a href="/users/list">
                    <i class="nav-icon i-Users"></i>
                    <span class="item-name">User List</span>
                </a>
                <a href="{{ route('teachers.register') }}">
                    <i class="nav-icon i-Users"></i>
                    <span class="item-name">Teacher Register</span>
                </a>
                <a href="{{ route('teachers.index') }}">
                    <i class="nav-icon i-Users"></i>
                    <span class="item-name">Teacher List</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/users/roles">
                    <i class="nav-icon i-Checked-User"></i>
                    <span class="item-name">Roles & Permissions</span>
                </a>
            </li>
        </ul>

        <!-- Settings Submenu -->
        <ul class="childNav" data-parent="settings">
            <li class="nav-item">
                <a href="/settings/profile">
                    <i class="nav-icon i-Male"></i>
                    <span class="item-name">Profile Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/settings/system">
                    <i class="nav-icon i-Settings-2"></i>
                    <span class="item-name">System Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay"></div>
</div>
