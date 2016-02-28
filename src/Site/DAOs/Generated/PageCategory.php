<?php

/**
 * 2016-02-28 20:42:06
 */
namespace Site\DAOs\Generated;

class PageCategory extends \Pz\DAOs\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'code' => 'extra1', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 5';
    }

    
}