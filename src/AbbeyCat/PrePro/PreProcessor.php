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
 * The preprocessor main class.
 *
 * @author AbbeyCat <abbeycatuk@gmail.com>
 */
class PreProcessor
{

    /** @var \PrePro\Parameters $parameters */
    protected $parameters;

    protected $map = array();
    protected $symbol_table = array();

    protected $statistics = array();

    public function __construct(\AbbeyCat\PrePro\Parser\ParametersInterface $parameters_parser)
    {
        // when PrePro is instantiated, it must immediately be able to parse configuration
        // parameters passed to it (however so) to ensure it has enough configuration to
        // understand what it will be working with when preprocessing is subsequently requested
        try {
            $this->parameters = $parameters_parser->parseParameters();
        } catch (\AbbeyCat\PrePro\Exception $e) {
            exit($e->getMessage() . "\r\n");
        }
    }

    public function preprocess(
        \AbbeyCat\PrePro\Parser\ConfigurationInterface $configuration_parser,
        \AbbeyCat\PrePro\Parser\DefinitionsInterface $definitions_parser,
        \AbbeyCat\PrePro\FolderSyncInterface $folder_sync
    ) {

        echo "prepro 0.9.9 by AbbeyCat.\n";

        /* parse the configuration file, obtaining a map of extension => affix mappings */
        $configuration = file_get_contents($this->parameters->config());
        echo "  - Loading configuration from {$this->parameters->config()}\n";
        $this->map = $configuration_parser->parseConfiguration($configuration);

        /* parse the definition file, obtaining a symbol table of symbol => definition mappings */
        $definitions = file($this->parameters->preprocess());
        echo "  - Loading definitions from {$this->parameters->preprocess()}\n";
        $this->symbol_table = $definitions_parser->parseDefinitions($definitions);

        /* reflect the input folder as the output folder, ready to preprocess */
        /* apply the symbol table to the output folder */
        echo "  - Preprocessing {$this->parameters->input()}/ to {$this->parameters->output()}/\n";
        $folder_sync->folderSync($this->parameters->input(), $this->parameters->output());
        $this->applySymbolTable($this->parameters->output());
        $this->outputStatistics();
    }

    protected function applySymbolTable($target)
    {
        $target .= '/';

        // apply symbol table to all files in the target directory
        $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned
        foreach ($files as $file) {

            $info = new \SplFileInfo($file);
            $extension = $info->getExtension();

            if (array_key_exists($extension, $this->map)) {
                $affix = $this->map[ $extension ];

                $file_content = file_get_contents($file);
                foreach ($this->symbol_table as $symbol => $definition) {
                    $file_content = str_replace("{$affix}{$symbol}{$affix}", $definition, $file_content);
                }
                file_put_contents($file, $file_content);
                if (!isset($this->statistics[$extension])) {
                    $this->statistics[$extension] = 1;
                } else {
                    $this->statistics[$extension]++;
                }
            }
        }

        // traverse any sub-directories as well
        $i = new \DirectoryIterator($target);
        foreach ($i as $f) {
            if (!$f->isDot() && $f->isDir()) {
                $this->applySymbolTable("{$target}{$f}");
            }
        }
    }

    protected function outputStatistics()
    {
        // output summary statistics
        $summary = '  - Preprocessed: ';
        if (count($this->statistics)) {
            foreach ($this->statistics as $extension => $count) {
                $summary .= "{$count} {$extension}, ";
            }
            $summary = substr( $summary, 0, strlen($summary)-2);
        } else {
            $summary .= '(none)';
        }
        print "{$summary}\n\n";
    }
}
