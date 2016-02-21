<?php

/**
 * 2016-02-20 11:04:36
 */
namespace Site\DAOs\Generated;

class ImageSize extends \Pz\DAOs\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'width' => 'extra1', 
			'description' => 'description', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getORMClass() {
        return 'Pz\Entities\Content';
    }

    function getBaseQuery() {
        return 'entity.modelId = 4';
    }

    
}