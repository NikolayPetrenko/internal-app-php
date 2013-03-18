<?php defined('SYSPATH') or die('No direct script access.');

class My_Layout_Controller extends Controller {
	
	protected $_separator   = ' | ';
	protected $_prefix 	= 'Travel';
	protected $_title 	= '';
	protected $_keywords	= '';
	protected $_description	= '';
	protected $_data	= array();

	public function before()
	{
                
		$config                 = Kohana::$config->load('config');
		$this->_title 		= $config->get('Site Title');
		$this->_keywords 	= $config->get('Site Keywords');
		$this->_description     = $config->get('Site Description');
                
                  Helper_Sly::createFilesFolderIFNotExist();
                
		Helper_Output::factory()
                                        ->link_css('bootstrap.min')
                                        ->link_css('screen')
                                        ->link_js('libs/jquery-1.8.2.min')
                                        ->link_js('libs/underscore-min')
                                        ->link_js('libs/jquery-ui-1.9.2.custom')
                                        ->link_js('libs/bootstrap.min')
                                        ->link_js('libs/tag-it')
                                        ->link_js('application')
                                        ;
	}

	/*
	*  SEO data
	*/
	public function setTitle($title = '')
	{
		if($title != '') {
			$this->_title = __($title).$this->_separator.__($this->_prefix);
		}
                
		return $this;
	}

	public function setKeyword($text = '')
	{
		if($text != '') {
			$this->_keywords = $text;
		}
		return $this;
	}

	public function setDescription($text = '')
	{
		if($text != '') {
			$this->_description = $text;
		}
		return $this;
	}

	/*
	* set partial template
	*/
	public function view($partials = '', $data = array())
	{
		$this->template->content = View::factory($partials);

		if(!empty($data)) {
			$this->setData($data, $this->template->content);
		}
		return $this;
	}

	public function setData($data = array(), $scope = false)
	{
		if(!empty($data)) {
			foreach ($data as $key => $value) {
				if($scope) {
					$scope->$key = $value;
				}
				$this->template->$key = $value;
			}
		}

		$this->_data = $data;

		return $this;
	}

	/*
	* @param $format:: html(default), json
	*/
	public function render($format = 'html')
	{
		 $this->template->title 		= $this->_title;
		 $this->template->keywords 		= $this->_keywords;
		 $this->template->description 	= $this->_description;
		 switch($format) {
		 	case 'html': 
		 		$this->response->body($this->template);
		 		break;
		 	case 'json':
		 		header('Content-type: text/json');
				header('Content-type: application/json');
				echo json_encode($this->_data);
		 		break;
		 }
	}
}