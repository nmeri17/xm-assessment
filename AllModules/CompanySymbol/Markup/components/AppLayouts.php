<?php

namespace AllModules\CompanySymbol\Markup\Components;

use Illuminate\View\Component;

class AppLayouts extends Component
{
    public function __construct($pageTitle, $scripts)
    {

        //
    }

    public function render()
    {

        return view("layouts.app");
    }
}
