<?php

/**
 * 2016-02-04 21:41:45
 */
namespace Site\DAOs\Generated;

class User extends \Pz\DAOs\DoctrineDAO {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'username', 
			'password' => 'password', 
			'password_' => 'extra1', 
			'name' => 'name', 
			'email' => 'email', 
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