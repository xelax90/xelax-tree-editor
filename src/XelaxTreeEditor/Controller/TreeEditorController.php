<?php

/*
 * Copyright (C) 2015 schurix
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace XelaxTreeEditor\Controller;

use XelaxAdmin\Controller\ListController;
use XelaxTreeEditor\Tree\TreeInterface;
use Zend\View\Model\ViewModel;

/**
 * Extension of ListController for user-friendly tree editing
 *
 * @author schurix
 */
class TreeEditorController extends ListController{
	
	protected function _showList($params){
		$params['rows'] = $this->getRoots($params['rows']);
		
		$page = $this->getEvent()->getRouteMatch()->getParam('p');
		$params['page'] = $page;
		
		$view = new ViewModel($params);
		$view->setTemplate('partial/admin_treelist.phtml');
		return $view;
	}
	
	protected function getRoots($items){
		$roots = array();
		foreach($items as $item){
			/* @var $item TreeInterface */
			if(!$item instanceof TreeInterface){
				throw new \Exception(sprintf('Expected %s, but found %s', TreeInterface::class, get_class($item)));
			}
			if(!$item->getParent()){
				$roots[] = $item;
			}
		}
		return $roots;
	}
}
