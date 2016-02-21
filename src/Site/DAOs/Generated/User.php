<?php

/**
 * 2016-02-20 11:30:36
 */
namespace Site\DAOs\Generated;

class User extends \Pz\DAOs\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'username', 
			'password' => 'password', 
			'password_' => 'extra1', 
			'image' => 'image', 
			'name' => 'name', 
			'email' => 'email', 
			'description' => 'description', 
			'resetToken' => 'extra2', 
			'resetDate' => 'date1', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getORMClass() {
        return 'Pz\Entities\Content';
    }

    function getBaseQuery() {
        return 'entity.modelId = 1';
    }

    
}