<?php
namespace SocialiteProviders\ThirtySevenSignals;

use SocialiteProviders\Manager\SocialiteWasCalled;

class ThirtySevenSignalsExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('37signals', __NAMESPACE__.'\Provider');
    }
}
