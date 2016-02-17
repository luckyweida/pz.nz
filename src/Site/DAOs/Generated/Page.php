<?php

/**
 * 2016-02-17 21:39:05
 */
namespace Site\DAOs\Generated;

class Page extends \Pz\DAOs\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'active' => 'extra1', 
			'type' => 'extra5', 
			'category' => 'category', 
			'url' => 'url', 
			'content' => 'content', 
			'categoryRank' => 'extra2', 
			'categoryParent' => 'extra3', 
			'pageTitle' => 'extra4', 
			'description' => 'description', 
			'redirectTo' => 'extra6', 
			'template' => 'authorbio', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getORMClass() {
        return 'Pz\Entities\Content';
    }

    function getBaseQuery() {
        return 'entity.modelId = 7';
    }

    
}