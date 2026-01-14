<?php

if (!function_exists('poStatusBadge')) {
    function poStatusBadge($status)
    {
        $colors = [
            'Pending'            => 'secondary',
            'Open'               => 'info',
            'Partially Received' => 'warning',
            'Received'           => 'success',
            'Completed'          => 'primary',
            'Cancelled'          => 'danger',
        ];

        $color = $colors[$status] ?? 'secondary';

        return "<span class='badge badge-$color'>$status</span>";
    }
}
