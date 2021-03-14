<?php 

namespace CMGDevs_PureTemplate;

class Json
{
	public $data = [];
	
	function __construct($data =[])
	{
		$this->data = $data;
		return $this;
	}

	private static function renderJSON()
	{
		/*no se necesita mostrar los asiguientes archivos*/
		//unset(self::$data['css'], self::$data['font'], self::$data['js']);

		extract(($this->data) ? $this->data: [], EXTR_SKIP);

		if(!headers_sent())
		{ header('Content-Type: "json; charset=UTF-8"'); }

		if( empty($this->data) || count($this->data) == 0 )
		{
			die('No Hay Datos que Mostrar');
		}
		//mostramos datos en json
		echo json_encode($this->data, JSON_PRETTY_PRINT);

	}
}

?>