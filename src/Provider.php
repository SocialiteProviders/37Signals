<?php
namespace SocialiteProviders\ThirtySevenSignals;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class Provider extends AbstractProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://launchpad.37signals.com/authorization/new', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://launchpad.37signals.com/authorization/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://launchpad.37signals.com/authorization.json', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true)['identity'];
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['id'],
            'nickname' => null,
            'name'     => $user['first_name'].' '.$user['last_name'],
            'email'    => $user['email_address'],
            'avatar'   => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'type'       => 'web_server',
            'grant_type' => 'authorization_code',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function buildAuthUrlFromBase($url, $state)
    {
        $session = $this->request->getSession();

        return $url.'?'.http_build_query([
            'type'          => 'web_server',
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUrl,
            'scope'         => $this->formatScopes($this->scopes, $this->scopeSeparator),
            'state'         => $state,
            'response_type' => 'code',
        ], '', '&', $this->encodingType);
    }
}
