<?php

/*
 * prepro
 *
 * Copyright (C) 2017 AbbeyCat (abbeycatuk@gmail.com)
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace AbbeyCat\PrePro;

/**
 * Specific Exception class defining all known application exceptions.
 *
 * @author AbbeyCat <abbeycatuk@gmail.com>
 */
class Exception extends \Exception
{
    const CODE_BAD_CLI_PARAMETERS       = 0x00000001;
    const TEXT_BAD_CLI_PARAMETERS       =
        'usage: prepro.php --input <path> --output <path> --config <path> --preprocess <path>';

    const CODE_MAPPINGS_MISSING         = 0x00000002;
    const TEXT_MAPPINGS_MISSING         = 'Mappings not found in configuration';

    const CODE_INVALID_DEFINITION       = 0x00000003;
    const TEXT_INVALID_DEFINITION       = 'Invalid definition';

    const CODE_ROOT_FOLDER              = 0x00000004;
    const TEXT_ROOT_FOLDER              = 'Cannot set / as target folder';

    const CODE_CANNOT_COPY_FROM_SOURCE  = 0x00000005;
    const TEXT_CANNOT_COPY_FROM_SOURCE  = 'Cannot copy from source folder';

    const CODE_CANNOT_COPY_TO_DEST      = 0x00000006;
    const TEXT_CANNOT_COPY_TO_DEST      = 'Cannot copy to destination folder';
}
