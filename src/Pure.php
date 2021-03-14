<?php namespace CMGDevs_PureTemplate;

require_once 'Template.php';
require_once 'Json.php';
require_once 'SiteMap.php';

use \CMGDevs_PureTemplate\cTemplate;
use \CMGDevs_PureTemplate\Json;
use \CMGDevs_PureTemplate\SiteMap;

class Pure extends cTemplate
{
	
	function __construct($viewsPath, $LayoutPath, $cachePath)
	{
		$this->definePath($viewsPath, $LayoutPath, $cachePath);
		return $this;
	}

	public function view($file, $data)
	{
		$file = $file.'.html';

		if( !file_exists( $this->viewsPath.$file ) )
		{
			print_r($this->viewsPath.$file . ' No se Encontro');
			die();
		}
		
		$cached_file = $this->cache($file);

	    extract($data, EXTR_SKIP);

	   
		if( isset( $_REQUEST['f'] ) && $_REQUEST['f'] == 'json')
		{
			//mostramos json
			$json = new Json($data);
			return $json->renderJSON();
		}

		if(!headers_sent())
		{
			header('Content-Type: "html; charset=UTF-8"');
		}
		//mostramos html
	   	require $cached_file;
	}

	public function viewMap(array $data, $typeOfMap)
	{
		$map = new SiteMap($data, $typeOfMap);
		$map->setCss('../xml.css');/*css opcional*/
		return $map->renderSiteMap();
	}



}

?>