<div 
    id="m_ver_menu" 
    class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " 
    data-menu-vertical="true"
    data-menu-scrollable="false" data-menu-dropdown-timeout="500"  
    >
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
        <?php echo $Title == "" ? "m-menu__item--active" : ""; ?>
        <li class="m-menu__item  <?php echo $Menu == "ATM Simulation" ? "m-menu__item--active" : ""; ?>" aria-haspopup="true" >
            <a  href="<?php echo site_url(); ?>" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">
                            ATM Simulation
                        </span>
                    </span>
                </span>
            </a>
        </li>
    </ul>
</div>

<script>
    $(document).ready(function () {
        // set active menu
        var item = $(document).find("a[href = '" + window.location.href + "']").parent('.m-menu__item');
        item.addClass('m-menu__item--active');
        item.parents('.m-menu__item--submenu').each(function () {
            $(this).addClass('m-menu__item--open');
        });
        // end set active menu



    });
</script>