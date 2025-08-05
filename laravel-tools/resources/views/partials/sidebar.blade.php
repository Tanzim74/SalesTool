<div class="side-content-wrap">
            <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="navigation-left">
                    <li class="nav-item" data-item="dashboard"><a class="nav-item-hold" href="#"><i class="nav-icon i-Bar-Chart"></i><span class="nav-text">Dashboard</span></a>
                        <div class="triangle"></div>
                    </li>

                    <li class="nav-item" data-item="forms"><a class="nav-item-hold" href="#"><i class="nav-icon i-File-Clipboard-File--Text"></i><span class="nav-text">Reports</span></a>
                        <div class="triangle"></div>
                    </li>
                  
                </ul>
            </div>

            <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <!-- Submenu Dashboards-->
             
                <ul class="childNav" data-parent="forms">
                    <li class="nav-item"><a href="{{ route('reports.sales') }}"><i class="nav-icon i-File-Clipboard-Text--Image"></i><span class="item-name">SALES</span></a></li>
                    <li class="nav-item"><a href="form.layouts.html"><i class="nav-icon i-Split-Vertical"></i><span class="item-name">CUSTOMER</span></a></li>
                </ul>
                <!-- chartjs-->
            </div>
            <div class="sidebar-overlay"></div>
        </div>