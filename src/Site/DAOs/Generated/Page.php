<?php

/**
 * 2016-02-26 20:50:54
 */
namespace Site\DAOs\Generated;

class Page extends \Pz\DAOs\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'isactive' => 'isactive', 
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

    function getBaseQuery() {
        return 'entity.modelId = 7';
    }

    
	public function getIsactive() {
		return $this->isactive == 1 ? true : false;
	}

}