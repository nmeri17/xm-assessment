<?php

namespace AllModules\CompanySymbol\Config;

use Suphle\Adapters\Presentation\Blade\DefaultBladeAdapter;

use AllModules\CompanySymbol\Markup\Components\AppLayout;

class CustomBladeAdapter extends DefaultBladeAdapter
{
    public function bindComponentTags(): void
    {

        $this->bladeCompiler->component("layout", AppLayouts::class);
    }
}