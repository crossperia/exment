<?php

namespace Exceedone\Exment\Enums;

use Exceedone\Exment\Services\Login as LoginServiceRoot;

/**
 * Sso Login Error Type Difinition.
 */
class SsoLoginErrorType extends EnumBase
{
    /**
     * Not exists provider user.
     * When jit is false.
     */
    const NOT_EXISTS_PROVIDER_USER = 'not_exists_provider_user';

    /**
     * provider undefined error.
     */
    const PROVIDER_ERROR = 'provider_error';

    /**
     * Sync mapping error.
     * Ex. cannot get email.
     */
    const SYNC_MAPPING_ERROR = 'sync_mapping_error';

    /**
     * Sync validation error.
     * Ex. email is null.
     */
    const SYNC_VALIDATION_ERROR = 'sync_validation_error';

    /**
     * Not accept domain.
     */
    const NOT_ACCEPT_DOMAIN = 'not_accept_domain';

    /**
     * Not exists exment user.
     * When jit is false.
     */
    const NOT_EXISTS_EXMENT_USER = 'not_exists_exment_user';

    const UNDEFINED_ERROR = 'undefined_error';
}
