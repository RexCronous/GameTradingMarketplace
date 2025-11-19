<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;

class CheckForMaintenanceMode extends PreventRequestsDuringMaintenance
{
    // Inherit behavior from framework middleware
}
