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
 * Methods required to operate as a Configuration parser.
 *
 * @author AbbeyCat <abbeycatuk@gmail.com>
 */
interface ConfigurationInterface
{
    public function parseConfiguration($configuration);
}
