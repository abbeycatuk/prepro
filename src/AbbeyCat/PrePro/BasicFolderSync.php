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
 * Handles the filesystem, copying input folder to output folder.
 *
 * @author AbbeyCat <abbeycatuk@gmail.com>
 */
class BasicFolderSync implements FolderSyncInterface
{
    public function folderSync($source, $target)
    {
        $source .= (substr($source, -1, 1) != '/') ? '/' : '';
        $target .= (substr($target, -1, 1) != '/') ? '/' : '';

        if ( $target === '/' ) {
            throw new Exception( Exception::TEXT_ROOT_FOLDER, Exception::CODE_ROOT_FOLDER);
        } else {
            $this->delete($target);
            $this->copy($source, $target);
        }
    }

    /*
     * php delete function that deals with directories recursively
     */
    protected function delete($target)
    {
        if (is_file($target)) {
            unlink($target);
        } elseif (is_dir($target)) {
            $files = new \DirectoryIterator($target);
            foreach ($files as $file) {
                if (!$file->isDot()) {
                    $this->delete(($file->isDir()) ? "{$target}/{$file}/" : "{$target}/{$file}");
                }
            }
            rmdir($target);
        }
    }

    /**
     * copy files from one directory to another recursively
     *
     * @param String $src - Source of files being moved
     * @param String $dest - Destination of files being moved
     */
    protected function copy($src, $dest)
    {
        if (!is_dir($src)) {
            throw new Exception(Exception::TEXT_CANNOT_COPY_FROM_SOURCE, Exception::CODE_CANNOT_COPY_FROM_SOURCE);
        }
        if (!is_dir($dest) && !mkdir($dest)) {
            throw new Exception(Exception::TEXT_CANNOT_COPY_TO_DEST, Exception::CODE_CANNOT_COPY_TO_DEST);
        }

        foreach (new \DirectoryIterator($src) as $fileinfo) {
            if ($fileinfo->isFile()) {
                copy($fileinfo->getRealPath(), "{$dest}/{$fileinfo->getFilename()}");
            } elseif ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $this->copy($fileinfo->getRealPath(), "{$dest}/{$fileinfo}");
            }
        }
    }
}
