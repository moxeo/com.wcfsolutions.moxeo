<?php
/**
 * Contains file manager-related functions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	util
 * @category	Infinite Site
 */
class FileManagerUtil {
	/**
	 * file manager root dir
	 * 
	 * @var	string
	 */
	protected static $rootDir = null;
	
	/**
	 * Returns true, if the given path is valid.
	 * 
	 * @param	string		$path
	 * @return	string
	 */
	public static function isValidPath($path) {
		$rootDir = self::getRootDir();
		if (substr($path, 0, strlen($rootDir)) != $rootDir) {
			return false;
		}
		if (!file_exists($path)) {
			return false;
		}
		return true;
	}
	
	/**
	 * Returns the file manager root dir.
	 * 
	 * @return	string
	 */
	public static function getRootDir() {
		if (self::$rootDir === null) {
			self::$rootDir = FileUtil::getRealPath(WSIS_DIR.'files/');
		}
		
		return self::$rootDir;
	}
	
	/**
	 * Returns the relative path of the given real path.
	 * 
	 * @param	string		$path
	 * @return	string
	 */
	public static function getRelativePath($path) {
		return substr($path, strlen(self::getRootDir()));
	}
	
	/**
	 * Returns the parent dir info.
	 * 
	 * @param	string		$dir
	 * @return	array
	 */
	public static function getParentDirInfo($dir) {
		return array(
			'name' => '..',
			'isDir' => 1,
			'size' => 0,
			'date' => 0,
			'permissions' => '',
			'relativePath' => self::getRelativePath(dirname(self::getRootDir().$dir))
		);
	}
	
	/**
	 * Returns the path of the given dir.
	 * 
	 * @param	string		$dir
	 * @return	string
	 */
	public static function getPath($dir) {
		$path = FileUtil::getRealPath(self::getRootDir().$dir);
		if (!self::isValidPath($path)) {
			return false;
		}
		
		return $path;
	}
	
	/**
	 * Returns a list of files of the given path.
	 * 
	 * @param	string		$path
	 * @return	array
	 */
	public static function getFiles($path) {
		$dir = self::getRelativePath($path);
		$files = array();
		
		// get files
		$dh = opendir($path);
		while (($filename = readdir($dh)) !== false) {
			if ($filename == '.' || $filename == '..') continue;
			
			$file = $path.$filename;
			$isDir = is_dir($file);
			
			$files[] = array(
				'name' => $filename,
				'isDir' => $isDir,
				'size' => ($isDir ? 0 : filesize($file)),
				'date' => filemtime($file),
				'permissions' => substr(sprintf('%o', fileperms($file)), -3),
				'relativePath' => $dir.$filename
			);
		}
		closedir($dh);
		
		return $files;	
	}
	
	/**
	 * Returns the file info of the given file.
	 * 
	 * @param	string		$file
	 * @return	array
	 */
	public static function getFileInfo($file) {
		$isDir = is_dir($file);
		$filename = basename($file);
		
		return array(
			'name' => $filename,
			'isDir' => $isDir,
			'size' => ($isDir ? 0 : filesize($file)),
			'date' => filemtime($file),
			'permissions' => substr(sprintf('%o', fileperms($file)), -3)
		);
	}
	
	/**
	 * Removes the dir with the given path.
	 * 
	 * @param	string		$dir
	 */
	public static function removeDir($dir) {
		// remove contents
		$dh = opendir($dir);
		while (($filename = readdir($dh)) !== false) {
			if ($filename == '.' || $filename == '..') continue;
			
			if (is_dir($dir.$filename)) {
				self::removeDir($dir.$filename.'/');
			}
			else {
				unlink($dir.$filename);
			}
		}
		closedir($dh);
		
		// remove dir
		rmdir($dir);
	}
	
	/**
	 * Returns true, if the filename has a valid file extension.
	 * 
	 * @param	string		$filename
	 * @return	boolean
	 */
	public static function hasValidFileExtension($filename) {
		$illegalFileExtensions = array('php', 'php3', 'php4', 'php5', 'phtml');
		
		// get file extension
		$fileExtension = '';
		if (!empty($filename) && StringUtil::indexOf($filename, '.') !== false) {
			$fileExtension = StringUtil::toLowerCase(StringUtil::substring($filename, StringUtil::lastIndexOf($filename, '.') + 1));
		}
		
		// check file extension
		if (in_array($fileExtension, $illegalFileExtensions)) {
			return false;
		}
		return true;
	}
}
?>