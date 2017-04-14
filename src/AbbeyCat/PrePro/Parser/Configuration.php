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
 * Handles parsing of configuration data to identify the mapping of filetypes to affixes.
 *
 * @author AbbeyCat <abbeycatuk@gmail.com>
 */
class Configuration implements ConfigurationInterface
{

    /**
     *
     * @param type $configuration
     * @throws \PrePro\Exception
     *
     * returns an Array of "extension" => "affix" mappings
     *
     */
    public function parseConfiguration($configuration)
    {
        // take in configuration text, parse, either fail and Exception, or pass and return a Mapping Set
        $ini_content = parse_ini_string($configuration, true);

        if (!isset($ini_content['mappings'])) {
            throw new \AbbeyCat\PrePro\Exception(
                \AbbeyCat\PrePro\Exception::TEXT_MAPPINGS_MISSING,
                \AbbeyCat\PrePro\Exception::CODE_MAPPINGS_MISSING
            );
        }

        $map = array();
        foreach ($ini_content['mappings'] as $filetypes => $affix) {
            foreach (explode(',', $filetypes) as $filetype) {
                $map[$filetype] = $affix;
            }
        }

        return $map;
    }
}
