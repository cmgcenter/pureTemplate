<?php

namespace CMGDevs_PureTemplate;

/**
 * 
 */
class SiteMap
{
	
	function __construct()
	{
		return $this;
	}

	public function renderSiteMap($map)
	{
		if(!headers_sent()){header("Content-Type: text/xml");}
		print($map);
		exit();
	}

	
}

?>