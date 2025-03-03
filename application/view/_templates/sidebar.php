<?php
function sidebarGenerateItems($urlDetails, $items, $counter = 0)
{
    $htm = '';
    foreach ($items as $v) {
        $counter++;

        $url = URL;
        if ($v['controller'] !== 'home') {
            $url = URL . $v['controller'];
        }

        if (!empty($v['action'])) {
            $url .= '/' . $v['action'];
        }

        $icon = '';
        if (empty($v['icon_type'])) { # default icon type is bi
            $icon = "<i class='bi " . $v['icon'] . "'></i>";
        }

        $isActive = false;
        $showSubItems = false;
        if ($v['controller'] === $urlDetails['controller']) {
            if (empty($v['action'])) {
                if (empty($urlDetails['action'])) {
                    $isActive = true;
                }
                $showSubItems = true;
            } else {
                if ($v['action'] === $urlDetails['action']) {
                    $isActive = true;
                    $showSubItems = true;
                } else {
                    // check if sub items has the "action" to show sub items
                    if (!empty($v['sub_items'])) {
                        foreach ($v['sub_items'] as $sub_v) {
                            if (isset($sub_v['action']) && $sub_v['action'] === $urlDetails['action']) {
                                $showSubItems = true;
                                break;
                            }
                        }
                    }
                }
            }
        }

        $htmSubItems = '';
        if (!empty($v['sub_items'])) {
            $navItemID = "rmsNavItem{$counter}";
            $htmNavLink = "<a href='#' class='nav-link has-sub-items" . ($showSubItems ? "" : " collapsed") . "' role='button' data-bs-toggle='collapse' data-bs-target='#" . $navItemID . "'>";

            $htmSubItems = "<div class='sub-items'>
				<div class='collapse" . ($showSubItems ? " show" : "") . "' id='{$navItemID}'>
					<ul class='list-unstyled small'>";

            $subItemsData = sidebarGenerateItems($urlDetails, $v['sub_items'], $counter);
            $htmSubItems .= $subItemsData['htm'];
            $counter = $subItemsData['counter'];

            $htmSubItems .= "</ul>
				</div>
			</div>";
        } else {
            $htmNavLink = "<a href='" . $url . "' class='nav-link" . ($isActive ? " active'" : "'") . ">";
        }

        $htm .= "<li class='nav-item'>
			{$htmNavLink}
				{$icon}
				{$v['label']}
			</a>
			{$htmSubItems}
		</li>";
    }
    return [
        'htm' => $htm,
        'counter' => $counter
    ];
}
?>

<i id="sidebarToggleOpen" class="bi bi-caret-right-fill"></i>
<div id="sidebar" class="d-flex flex-column">
    <i id="sidebarToggleClose" class="bi bi-caret-left-fill"></i>
    <ul id="sidebarItems" class="nav nav-pills flex-column mb-auto">
        <?php
        $navItems = [];
        $navItems[] = [
            'controller' => 'home',
            'icon' => 'bi-house-door',
            'label' => 'Home'
        ];
        // $navItems[] = [
        //     'controller' => 'test',
        //     'icon' => 'bi-peace',
        //     'label' => 'Test',
        //     'sub_items' => [
        //         [
        //             'controller' => 'test',
        //             'icon' => 'bi-caret-right',
        //             'label' => 'Test Home'
        //         ],
        //         [
        //             'controller' => 'test',
        //             'action' => 'sub_1',
        //             'icon' => 'bi-caret-right',
        //             'label' => 'Test Sub 1'
        //         ],
        //         [
        //             'controller' => 'test',
        //             'action' => 'sub_2',
        //             'icon' => 'bi-caret-right',
        //             'label' => 'Test Sub 2',
        //             'sub_items' => [
        //                 [
        //                     'controller' => 'test',
        //                     'action' => 'sub_2',
        //                     'icon' => 'bi-caret-right',
        //                     'label' => 'Test Sub 2 Home'
        //                 ],
        //                 [
        //                     'controller' => 'test',
        //                     'action' => 'sub_2_1',
        //                     'icon' => 'bi-caret-right',
        //                     'label' => 'Test Sub 2-1'
        //                 ],
        //                 [
        //                     'controller' => 'test',
        //                     'action' => 'sub_2_2',
        //                     'icon' => 'bi-caret-right',
        //                     'label' => 'Test Sub 2-2'
        //                 ]
        //             ]
        //         ],
        //     ]
        // ];

        $navItems[] = [
            'controller' => 'landing-page-builder',
            'icon' => 'bi bi-file-earmark',
            'label' => 'Landing Page Builder'
        ];

        // $navItems[] = [
        //     'controller' => 'appointment-booking-client',
        //     'action' => 'hotel',
        //     'icon' => 'bi bi-building',
        //     'label' => 'Hotel (Frontend)'
        // ];

        // $navItems[] = [
        //     'controller' => 'appointment-booking-client',
        //     'action' => 'photographer',
        //     'icon' => 'bi bi-camera2',
        //     'label' => 'Photographer (Frontend)'
        // ];

        // $navItems[] = [
        //     'controller' => 'appointment-booking-client',
        //     'action' => 'boutique',
        //     'icon' => 'bi bi-shop-window',
        //     'label' => 'Boutique (Frontend)'
        //];

        // $navItems[] = [
        //     'controller' => 'appointment-booking',
        //     'icon' => 'bi bi-calendar-check',
        //     'label' => 'Appointment Booking'
        // ];

        // $navItems[] = [
        //     'controller' => 'appointment-booking',
        //     'icon' => 'bi bi-calendar-check',
        //     'label' => 'Appointment Booking',
        //     'sub_items' => [
        //         [
        //             'controller' => 'appointment-booking',
        //             'action' => 'hotel',
        //             'icon' => 'bi bi-building',
        //             'label' => 'Hotel'
        //         ],
        //         [
        //             'controller' => 'appointment-booking',
        //             'action' => 'photographer',
        //             'icon' => 'bi bi-camera2',
        //             'label' => 'Photographer'
        //         ],
        //         [
        //             'controller' => 'appointment-booking',
        //             'action' => 'boutique',
        //             'icon' => 'bi bi-shop-window',
        //             'label' => 'Boutique'
        //         ],
        //     ]
        // ];

        echo sidebarGenerateItems($this->urlDetails, $navItems)['htm'];
        ?>
    </ul>
</div>