<?php

namespace App\Auth;

use PHPNomad\Auth\Interfaces\Action;
use PHPNomad\Auth\Interfaces\User;

/**
 * @TODO
 *
 * This template comes with a basic passthrough user class. If your application needs to have identifiable
 * users, you will need to implement this class yourself, or use a package that handles it.
 */
class PassthroughUser implements User
{
    public function getIdentity(): array
    {
        return [];
    }

    public function getId()
    {
        return 1;
    }

    public function getEmail(): string
    {
        return 'passthrough@pass.through';
    }

    public function canDoAction(Action $action): bool
    {
        return true;
    }
}