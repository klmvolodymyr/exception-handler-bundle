<?php

namespace VolodymyrKlymniuk\ExceptionHandlerBundle;

final class ExceptionHandlerMessages
{
    /**
     * Internal server errrors
     */
    const INTERNAL_ERROR = 'Sorry, something went wrong. We cannot complete this operation at this time.';

    /**
     * Data validation errors
     */
    const VALIDATION_ERROR = 'Sorry, something went wrong. We cannot complete this operation at this time. Code: Invalid request parameters.';

    /**
     * Access denied to the application
     */
    const ACCESS_DENIED = 'Access denied.';

    /**
     * Access denied to the application
     */
    const UNAUTHORIZED = 'Unauthorized.';
}