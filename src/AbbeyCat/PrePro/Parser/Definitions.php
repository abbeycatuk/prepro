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
 * Handles parsing of preprocessor definitions.
 *
 * @author AbbeyCat <abbeycatuk@gmail.com>
 */
class Definitions implements DefinitionsInterface
{

    /**
     *
     * @param type $definitions
     * @return string
     *
     * definitions is the an array of each line from the definitions file - treat either as
     * ; <comment>
     * or
     * #define <expr> <expr>
     *
     */
    public function parseDefinitions($definitions)
    {

        $symbol_table = array();

        foreach ($definitions as $line) {
            $line = ltrim($line);
            if (empty($line) || substr($line, 0, 1) == ';') {
                continue;
            }
            if (substr($line, 0, 7) == '#define') {
                $matches = array();
                preg_match_all('/^#define(\s+)(\S+)(\s+)(.*)$/', $line, $matches, PREG_SET_ORDER, 0);
                $symbol = $matches[0][2];
                $definition = $matches[0][4];
                $symbol_table[$symbol] = $definition;
            } else {
                throw new \AbbeyCat\PrePro\Exception(
                    \AbbeyCat\PrePro\Exception::TEXT_INVALID_DEFINITION,
                    \AbbeyCat\PrePro\Exception::CODE_INVALID_DEFINITION
                );
            }
        }

        return $symbol_table;
    }
}
