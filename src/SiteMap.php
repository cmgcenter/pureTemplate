<?php

namespace CMGDevs_PureTemplate;

/**
 * 
 */
class SiteMap
{
	private $map;
	protected $code = '';
	protected $css='';
	protected $type;

	function __construct($map, $type)
	{
		$this->code = '<?xml version="1.0" encoding="UTF-8"?>';
		$this->map = $map;
		$this->type = $type;
		return $this;
	}

	public function Mapping()
	{
		$this->code.= (empty($this->css)) ? '': $this->css;
		$this->code.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

		if( is_array($this->map) )
		{
			$cantOfItems = count($this->map);

			for ($i=0; $i < $cantOfItems; $i++)
			{ 
				$this->code .='<'.$this->type.'>
				<name>'.$this->map[$i]['name'].'</name>
   				<url>'. $this->map[$i]['url'].'</url>
   				</'.$this->type.'>';
			}

			//cerramos el sitmap
			$this->code .='</urlset> ';

			//print_r($this->code);
			return $this->code;
		}
		else
		{
			die('no siteMap Format');
		}
	}

	public function renderSiteMap()
	{
		$map = $this->Mapping();

		if(!headers_sent()){header("Content-Type: text/xml");}
		return print($map);
		exit();
	}

	public function setCss($path)
	{
		$this->css = '<?xml-stylesheet href="'.$path.'"?>';
	}

	
}

?>