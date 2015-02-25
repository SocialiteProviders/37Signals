<?php
namespace SocialiteProviders\ThirtySevenSignals;

use SocialiteProviders\Manager\SocialiteWasCalled;

class ThirtySevenSignalsExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            '37signals', __NAMESPACE__.'\Provider'
        );
    }
}
