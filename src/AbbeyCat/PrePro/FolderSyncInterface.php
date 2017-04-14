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
 * Methods required to operate as a FolderSync class.
 *
 * @author AbbeyCat <abbeycatuk@gmail.com>
 */
interface FolderSyncInterface
{
    public function folderSync($source, $target);
}
