<?php
// wcf imports
require_once(WCF_DIR.'lib/form/AbstractForm.class.php');

/**
 * Shows the file manager file add form.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.form
 * @category	Infinite Site
 */
class FileManagerFileAddForm extends AbstractForm {
	/**
	 * dir name
	 * 
	 * @var	string
	 */
	public $dir = '';
	
	/**
	 * path
	 * 
	 * @var	string
	 */
	public $path = '';
	
	// parameters
	public $fileType = 'folder';
	public $dirName = '';
	public $fileUpload;
	
	/**
	 * Creates a new FileManagerFileAddForm object.
	 * 
	 * @param	string		$dir
	 * @param	string		$path
	 */
	public function __construct($dir, $path) {
		$this->dir = $dir;
		$this->path = $path;
		parent::__construct();
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['fileType'])) $this->fileType = $_POST['fileType'];
		if (isset($_POST['dirName'])) $this->dirName = $_POST['dirName'];
		if (isset($_FILES['fileUpload'])) $this->fileUpload = $_FILES['fileUpload'];
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// file type
		switch ($this->fileType) {
			case 'folder':
			case 'file': break;
			default: throw new UserInputException('fileType', 'invalid');
		}
		
		// dir name
		if ($this->fileType == 'folder') {
			if (empty($this->dirName)) {
				throw new UserInputException('dirName');
			}
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		// folder
		if ($this->fileType == 'folder') {
			@mkdir($this->path.$this->dirName, 0777, true);
			@chmod($this->path.$this->dirName, 0777);
		}
		// file
		else if ($this->fileType == 'file') {
			if ($this->fileUpload && $this->fileUpload['error'] != 4) {
				if ($this->fileUpload['error'] != 0) {
					throw new UserInputException('fileUpload');
				}
				
				if (!FileManagerUtil::hasValidFileExtension($this->fileUpload['name'])) {
					throw new UserInputException('fileUpload');
				}
				
				if (!@move_uploaded_file($this->fileUpload['tmp_name'], $this->path.$this->fileUpload['name'])) {
					throw new UserInputException('fileUpload');
				}
				@chmod($this->path.$this->fileUpload['name'], 0777);
			}
			else {
				throw new UserInputException('fileUpload');
			}
		}
		$this->saved();
		
		// forward to list page
		HeaderUtil::redirect('index.php?page=FileManager&dir='.$this->dir.'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'action' => 'add',
			'fileType' => $this->fileType,
			'dirName' => $this->dirName
		));
	}
}
?>