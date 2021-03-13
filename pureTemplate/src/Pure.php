<?php 

namespace CMGDevs\PureTemplate;

use \CMGDevs\PureTemplate\cTemplate;
use \CMGDevs\PureTemplate\Json;
use \CMGDevs\PureTemplate\SiteMap;

class Pure extends cTemplate
{

	protected $currentTemplate = '';
	static $blocks = array();
	
	function __construct($viewsPath, $LayoutPath, $cachePath)
	{
		$this->definePath($viewsPath, $LayoutPath);
		return $this;
	}

	public function view($file, $data)
	{
		$file = $this->viewsPath.'/'.$file;

		$cached_file = $this->cache($file);

	    extract($data, EXTR_SKIP);

	   
		if( isset( $_REQUEST['f'] ) && $_REQUEST['f'] == 'json')
		{
			//mostramos json
			return $this->renderJSON();
		}

		if(!headers_sent())
		{
			header('Content-Type: "html; charset=UTF-8"');
		}
		//mostramos html
	   	require $cached_file;
	}

	public function viewMap($data)
	{
		$this->renderSiteMap($data);
	}



}

?>