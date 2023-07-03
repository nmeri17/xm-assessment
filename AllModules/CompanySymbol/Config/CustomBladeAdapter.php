<?php

namespace AllModules\CompanySymbol\Config;

use Suphle\Adapters\Presentation\Blade\DefaultBladeAdapter;

use AllModules\CompanySymbol\Markup\Components\AppLayouts;

class CustomBladeAdapter extends DefaultBladeAdapter
{
    public function bindComponentTags(): void
    {

        $this->bladeCompiler->component("layout", AppLayouts::class);
    }
}