<?php
// wcf imports
require_once(WCF_DIR.'lib/form/AbstractForm.class.php');

/**
 * Shows the file manager file add form.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.form
 * @category	Moxeo Open Source CMS
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
	public $fileType = 'file';
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

			if ($this->dirName == '.' || $this->dirName == '..') {
				throw new UserInputException('dirName');
			}

			if (str_replace(array('/', '\\'), '', $this->dirName) != $this->dirName) {
				throw new UserInputException('dirName');
			}
		}

		// files
		else if ($this->fileType == 'file') {
			if (isset($this->fileUpload['name']) && count($this->fileUpload['name'])) {
				$errors = array();
				for ($x = 0, $y = count($this->fileUpload['name']); $x < $y; $x++) {
					if (!empty($this->fileUpload['name'][$x])) {
						try {
							// check upload
							if ($this->fileUpload['error'][$x] != 0) {
								throw new UserInputException('fileUpload', 'uploadFailed');
							}

							if (!FileManagerUtil::hasValidFileExtension($this->fileUpload['name'][$x])) {
								throw new UserInputException('fileUpload', 'illegalExtension');
							}

							if (!@move_uploaded_file($this->fileUpload['tmp_name'][$x], $this->path.$this->fileUpload['name'][$x])) {
								throw new UserInputException('fileUpload', 'copyFailed');
							}
							@chmod($this->path.$this->fileUpload['name'][$x], 0777);
						}
						catch (UserInputException $e) {
							$errors[] = array('errorType' => $e->getType(), 'filename' => $this->fileUpload['name'][$x]);
						}
					}
				}

				// show error message
				if (count($errors)) {
					throw new UserInputException('fileUpload', $errors);
				}

			}
			else {
				throw new UserInputException('fileUpload');
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
		$this->saved();

		// forward to list page
		HeaderUtil::redirect('index.php?page=FileManager&dir='.urlencode($this->dir).'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
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