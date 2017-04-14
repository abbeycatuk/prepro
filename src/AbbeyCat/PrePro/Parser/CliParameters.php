<?php

/*
 * prepro
 *
 * Copyright (C) 2017 AbbeyCat (abbeycatuk@gmail.com)
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace AbbeyCat\PrePro\Parser;

/**
 * Handles parsing of parameters supplied to the application via CLI.
 *
 * @author AbbeyCat <abbeycatuk@gmail.com>
 */
class CliParameters implements ParametersInterface
{
    public function parseParameters()
    {

        $long_opts = array('input:', 'output:', 'config:', 'preprocess:');
        $params = getopt('', $long_opts);
        if (count($params) < count($long_opts)) {
            throw new \AbbeyCat\PrePro\Exception(
                \AbbeyCat\PrePro\Exception::TEXT_BAD_CLI_PARAMETERS,
                \AbbeyCat\PrePro\Exception::CODE_BAD_CLI_PARAMETERS
            );
        }

        return new \AbbeyCat\PrePro\Parameters(
            $params['input'],
            $params['output'],
            $params['config'],
            $params['preprocess']
        );
    }
}
