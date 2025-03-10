<?php

declare(strict_types=1);

namespace SPC\builder\extension;

use SPC\builder\Extension;
use SPC\exception\RuntimeException;
use SPC\util\CustomExt;

#[CustomExt('mbregex')]
class mbregex extends Extension
{
    public function getConfigureArg(): string
    {
        return '';
    }

    /**
     * mbregex is not an extension, we need to overwrite the default check.
     */
    public function runCliCheck(): void
    {
        [$ret] = shell()->execWithResult(BUILD_ROOT_PATH . '/bin/php --ri "mbstring" | grep regex', false);
        if ($ret !== 0) {
            throw new RuntimeException('extension ' . $this->getName() . ' failed compile check: compiled php-cli mbstring extension does not contain regex !');
        }
    }
}
