<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/content/ContentItem.class.php');
require_once(WSIS_DIR.'lib/system/request/ContentItemRequest.class.php');

/**
 * Handles http request.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.content
 * @category	Infinite Site
 */
class ContentItemRequestHandler {
	/**
	 * content item request handler object
	 * 
	 * @var	ContentItemRequestHandler
	 */
	private static $instance = null;
	
	/**
	 * content item id
	 * 
	 * @var	integer
	 */
	protected $contentItemID = null;
	
	/**
	 * language id
	 * 
	 * @var	integer
	 */
	protected $languageID = null;
	
	/**
	 * request basename
	 * 
	 * @var	string
	 */
	protected $basename = null;
	
	/**
	 * request filename
	 * 
	 * @var	string
	 */
	protected $filename = null;
	
	/**
	 * active request object
	 * 
	 * @var	ContentItemRequest
	 */
	protected $activeRequest = null;
	
	/**
	 * Creates a new ContentItemRequestHandler object.
	 */
	protected final function __construct() {}
	
	/**
	 * Returns the request basename.
	 * 
	 * @return	string
	 */
	public function getBasename() {
		if ($this->basename === null) {
			$path = '/';
			$urlComponents = @parse_url(PAGE_URL);
			if (!empty($urlComponents['path'])) $path = '/'.FileUtil::removeLeadingSlash(FileUtil::addTrailingSlash($urlComponents['path']));
			$this->basename = FileUtil::removeTrailingSlash(substr(urldecode($_SERVER['REQUEST_URI']), strlen($path)));
			
			// remove query string
			$this->basename = preg_replace('/(?:\?|&)s=[a-f0-9]{40}/', '', $this->basename);
		}
		
		return $this->basename;
	}
	
	/**
	 * Returns the request filename.
	 * 
	 * @return	string
	 */
	public function getFilename() {
		if ($this->filename === null) {
			$basename = $this->getBasename();
			$length = StringUtil::length($basename);
			if ($length > 5 && StringUtil::indexOf($basename, '.html', $length-5)) {
				$this->filename = basename($basename, '.html');
			}
		}
		
		return $this->filename;
	}
	
	/**
	 * Returns the requested content item id.
	 * 
	 * @return	integer
	 */
	public function getContentItemID() {
		if ($this->contentItemID === null) {
			// get request fragments
			$requestFragments = array();
			$basename = $this->getBasename();
			if ($basename) {
				$requestFragments = explode('/', $basename);
				if (!ENABLE_SEO_REWRITING) {
					array_shift($requestFragments);
				}
			}
			
			// define url prefix
			if (ENABLE_SEO_REWRITING) define('URL_PREFIX', '');
			else define('URL_PREFIX', 'index.php/');
			
			// load seo structure
			$contentItemStructure = WCF::getCache()->get('contentItemAlias');
			
			// get content item id
			$contentItemID = 0;
			if (count($requestFragments)) {
				$parentContentItemID = $level = 0;
				$contentItemAlias = $requestFragments[0];
				while (isset($contentItemStructure[$parentContentItemID][$contentItemAlias])) {
					$contentItemID = $contentItemStructure[$parentContentItemID][$contentItemAlias];
					
					// next content item
					$parentContentItemID = $contentItemID;
					$level++;
					if (isset($requestFragments[$level])) {
						$contentItemAlias = $requestFragments[$level];
					}
				}
			}
			else {
				Language::$cache = WCF::getCache()->get('languages');
				$contentItemID = ContentItem::getIndexContentItemID(WCF::getSession()->getLanguageID());
			}
			$this->contentItemID = $contentItemID;
		}
		
		return $this->contentItemID;
	}
	
	/**
	 * Returns the request language id.
	 * 
	 * @return	integer
	 */
	public function getLanguageID() {
		if ($this->languageID === null) {
			$this->languageID = WCF::getSession()->getLanguageID();
			
			// get language id of content item
			$contentItemID = $this->getContentItemID();
			if ($contentItemID) {
				$this->languageID = ContentItem::getContentItem($contentItemID)->languageID;
			}
		}
		
		return $this->languageID;
	}
	
	/**
	 * Handles a http request.
	 */
	public function handle() {
		try {
			$this->activeRequest = new ContentItemRequest($this->getContentItemID());
			$this->activeRequest->execute();
		}
		catch (PermissionDeniedException $e) {
			throw new WSISPermissionDeniedException();
		}
		catch (IllegalLinkException $e) {
			throw new WSISIllegalLinkException();
		}
	}
	
	/**
	 * Returns the active request object.
	 * 
	 * @return Request
	 */
	public function getActiveRequest() {
		return $this->activeRequest;
	}
	
	/**
	 * Returns an instance of the ContentItemRequestHandler class.
	 * 
	 * @return	ContentItemRequestHandler
	 */
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new ContentItemRequestHandler();
		}
		
		return self::$instance;
	}
}
?>