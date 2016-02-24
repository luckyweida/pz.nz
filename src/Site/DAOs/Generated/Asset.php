<?php

/**
 * 2016-02-24 20:49:37
 */
namespace Site\DAOs\Generated;

class Asset extends \Pz\DAOs\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'description' => 'description', 
			'isFolder' => 'extra1', 
			'fileName' => 'extra2', 
			'fileType' => 'extra4', 
			'fileSize' => 'extra5', 
			'fileLocation' => 'extra6', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getORMClass() {
        return 'Pz\Entities\Content';
    }

    function getBaseQuery() {
        return 'entity.modelId = 3';
    }

    
}