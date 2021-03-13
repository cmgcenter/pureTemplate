<?php 

namespace CMGDevs\PureTemplate;

/**
 * 
 */
class cTemplate
{
	public $viewsPath = '';
	public $LayoutPath = '';
	public $cachePath = '';

	
	function __construct()
	{
		return $this;
	}

	public function definePath($viewsPath, $LayoutPath, $cachePath)
	{
		$this->viewsPath = $viewsPath;
		$this->LayoutPath = $LayoutPath;
		$this->cachePath = $cachePath;

		//tras definir las rutas, las verificamos
		$this->checkLayout();
		$this->CheckTemplate();
	}

	public function checkLayout()
	{
		if(!file_exists($this->LayoutPath))
		{
			mkdir($dir, 0777, true);
		}
	}

	public function CheckTemplate()
	{
		if (!file_exists($this->viewsPath)) 
		{
    		mkdir($this->viewsPath, 0777, true);
		}

		elseif (!file_exists($this->cachePath)) 
		{
    		mkdir($this->cachePath, 0777, true);
		}
	}

	public function cache($file)
	{
	    $cached_file = $this->cache_path . str_replace(array('/', '.php'), array('_', ''), $file . '.htm');

	    if (!$this->cache_enabled || !file_exists($cached_file) || filemtime($cached_file) < filemtime($file)) 
	    {
			$code = $this->includeFiles($file);
			$code = $this->compileCode($code);
	        file_put_contents($cached_file, '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code);
	    }

	    //file_put_contents(self::$cache_path.'cache.html', htmlspecialchars_decode($code));
		
		return $cached_file;
	}

	public function clearCache() 
	{
		foreach(glob($this->cache_path . '*') as $file) {
			unlink($file);
		}
	}

	public function compileCode($code) {
		$code = $this->compileBlock($code);
		$code = $this->compileYield($code);
		$code = $this->compileEscapedEchos($code);
		$code = $this->compileEchos($code);
		$code = $this->compilePHP($code);
		$code = $this->compileShortPHP($code);
		$code = $this->compileForeach($code);

		return $code;
	}

	public function compilePHP($code) {
		return preg_replace('~\{\s*(.+?)\s*\}~is', '<?php $1 ?>', $code);
	}

	public function compileShortPHP($code) {
		return preg_replace('~\{\s*(.+?)\s*\}~is', '<?= $1 ?>', $code);
	}	

	public function compileForeach($code) {
		preg_match_all('/{ ?foreach ?(.*?) ?}(.*?){ ?endforeach ?}/is', $code, $matches, PREG_SET_ORDER);
		foreach ($matches as $value) {
			if (!array_key_exists($value[1], self::$blocks)) $this->blocks[$value[1]] = '';
			if (strpos($value[2], '@parent') === false) {
				$this->blocks[$value[1]] = $value[2];
			} else {
				$this->blocks[$value[1]] = str_replace('@parent', $this->blocks[$value[1]], $value[2]);
			}
			$code = str_replace($value[0], '', $code);
		}
		return $code;
	}


	public function compileEchos($code) {
		return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1 ?>', $code);
	}

	public function compileEscapedEchos($code) {
		return preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
	}

	public function compileBlock($code) {
		preg_match_all('/{ ?block ?(.*?) ?}(.*?){ ?endblock ?}/is', $code, $matches, PREG_SET_ORDER);
		foreach ($matches as $value) {
			if (!array_key_exists($value[1], $this->blocks)) $this->blocks[$value[1]] = '';
			if (strpos($value[2], '@parent') === false) {
				$this->blocks[$value[1]] = $value[2];
			} else {
				$this->blocks[$value[1]] = str_replace('@parent', $this->blocks[$value[1]], $value[2]);
			}
			$code = str_replace($value[0], '', $code);
		}
		return $code;
	}

	public function compileYield($code) {
		foreach($this->blocks as $block => $value) {
			$code = preg_replace('/{ ?yield ?' . $block . ' ?}/', $value, $code);
		}
		$code = preg_replace('/{ ?yield ?(.*?) ?}/i', '', $code);
		return $code;
	}

	public function includeFiles($file) {
		$code = file_get_contents($file);
		preg_match_all('/{ ?(extends|include) ?\'?(.*?)\'? ?}/i', $code, $matches, PREG_SET_ORDER);
		foreach ($matches as $value) {
			$code = str_replace($value[0], $this->includeFiles($value[2]), $code);
		}
		$code = preg_replace('/{ ?(extends|include) ?\'?(.*?)\'? ?}/i', '', $code);
		return $code;
	}
}
	

?>