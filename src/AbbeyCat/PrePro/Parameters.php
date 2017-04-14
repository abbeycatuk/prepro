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
 * Value Object collating all run-time parameters.
 *
 * @author AbbeyCat <abbeycatuk@gmail.com>
 */
class Parameters
{
    protected $input;
    protected $output;
    protected $config;
    protected $preprocess;

    public function __construct($input, $output, $config, $preprocess)
    {
        $this->input = $input;
        $this->output = $output;
        $this->config = $config;
        $this->preprocess = $preprocess;
    }

    public function input()
    {
        return $this->input;
    }

    public function output()
    {
        return $this->output;
    }

    public function config()
    {
        return $this->config;
    }

    public function preprocess()
    {
        return $this->preprocess;
    }
}
