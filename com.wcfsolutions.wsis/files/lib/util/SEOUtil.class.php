<?php
/**
 * Contains seo-related functions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	util
 * @category	Infinite Site
 */
class SEOUtil {
	/**
	 * Returns the formatted seo string.
	 * 
	 * @param	string		$string
	 * @return	string
	 */
	public static function formatString($string) {
		$string = StringUtil::toLowerCase($string);
		
		// remove illegal characters
		$string = preg_replace('/[\x0-\x2F\x3A-\x40\x5B-\x60\x7B-\x7F\x80-\xFF]+/', '-', $string);
		
		// trim string
		$string = trim($string, '-');
		
		return $string;
	}
	
	/**
	 * Writes rewrite rules to the config file.
	 */
	public static function rebuildConfigFile() {
		// get options
		require_once(WCF_DIR.'lib/acp/option/Options.class.php');
		$options = Options::getOptionValues();
		
		// get existing content of file
		$filename = WSIS_DIR.'.htaccess';
		$existingContent = '';
		if (file_exists($filename)) {
			$existingContent = StringUtil::unifyNewlines(file_get_contents($filename));
			
			// remove existing seo rules
			$existingContent = preg_replace("~\n?# WSIS-SEO-START.*# WSIS-SEO-END~s", '', $existingContent);
		}
	
		// open file
		$file = new File($filename);
		
		// chmod file
		@$file->chmod(777);
		
		// reinsert existing content
		if (!empty($existingContent)) {
			$file->write($existingContent);
		}
		
		if ($options['ENABLE_SEO_REWRITING']) {			
			// write start comment
			$file->write("\n# WSIS-SEO-START\n");
			
			// write opening ifmodule tag
			$file->write("<IfModule mod_rewrite.c>\n");
			
			// write rewrite engine on
			$file->write("RewriteEngine On\n");
			
			// write rewrite base
			$rewriteBase = '/';
			$urlComponents = @parse_url(PAGE_URL);
			if (!empty($urlComponents['path'])) $rewriteBase = $urlComponents['path'];
			
			$file->write("RewriteBase ".$rewriteBase."\n\n");
			
			// write rewrite rule
			$file->write("RewriteCond %{REQUEST_FILENAME} !-f\n");
			$file->write("RewriteCond %{REQUEST_FILENAME} !-d\n");
			$file->write("RewriteRule ^([^/\.]+/)*([^/\.]+\.html)?$ index.php/$1$2 [L,QSA]\n");
			
			// write closing ifmodule tag
			$file->write("</IfModule>\n");
			
			// write end comment
			$file->write("# WSIS-SEO-END");
		}
			
		// close file
		$file->close();
		
		// remove empty file
		if (!StringUtil::trim($existingContent)) {
			@$file->unlink();
		}
	}
}
?>