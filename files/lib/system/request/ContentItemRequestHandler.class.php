<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');
require_once(MOXEO_DIR.'lib/system/request/ContentItemRequest.class.php');

/**
 * Handles http request.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.content
 * @category	Moxeo Open Source CMS
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
	 * root id
	 *
	 * @var	integer
	 */
	protected $rootID = null;

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

			$requestURLComponents = @parse_url(urldecode($_SERVER['REQUEST_URI']));
			$this->basename = FileUtil::removeTrailingSlash(substr($requestURLComponents['path'], strlen($path)));
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
			$length = strlen($basename);
			if ($length > 5 && strpos($basename, '.html', $length-5)) {
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
			// define url prefix
			define('URL_PREFIX', (ENABLE_SEO_REWRITING ? '' : 'index.php/'));

			list($this->contentItemID, $this->rootID) = $this->getContentItemData($this->getBasename());
		}

		return $this->contentItemID;
	}

	/**
	 * Returns the root id of the requested content item id.
	 *
	 * @return	integer
	 */
	public function getRootID() {
		if ($this->contentItemID === null) {
			$this->getContentItemID();
		}

		return $this->rootID;
	}

	/**
	 * Returns the content item data (content item id and corresponding root id) of the given basename.
	 *
	 * @param	string		$basename
	 * @return	array
	 */
	protected function getContentItemData($basename) {
		// read url components
		$urlComponents = array();
		if ($basename) {
			$urlComponents = explode('/', $basename);
			if (!ENABLE_SEO_REWRITING) {
				array_shift($urlComponents);
			}
		}

		// count url components
		$numberOfUC = count($urlComponents);

		// user has requested a content item
		if ($numberOfUC > 0) {
			$isSuperRootURL = false;
			$cache = WCF::getCache()->get('contentItemAlias');

			// find root
			// look if there are roots which match the first url component
			if (isset($cache[0][$urlComponents[0]])) {
				$rootID = $cache[0][$urlComponents[0]];
			}
			// url component might be the alias of a child of the super root
			else {
				$isSuperRootURL = true;
				$rootID = ContentItem::getSuperRootID();
			}

			// handle non-existing root
			if ($rootID == 0) {
				// find root of error page
				$languageID = ContentItem::getInitialRootLanguageID();
				$rootID = ContentItem::getRootIDByLanguageID($languageID);

				// if there is still no suitable root, use first root
				if ($rootID == 0) {
					$rootID = ContentItem::getFirstRootID();
				}

				return array(0, $rootID);
			}

			// handle non-super root urls
			if (!$isSuperRootURL) {
				// if only the root is known, find index content item of this root
				if ($numberOfUC == 1) {
					$contentItemID = ContentItem::getIndexContentItemID($rootID);
					return array($contentItemID, $rootID);
				}

				// shift first url component (as it has already been processed)
				array_shift($urlComponents);
				$numberOfUC--;
			}

			// find requested content item by processing the other url components
			$contentItemID = $rootID;
			$count = 0;
			while (($contentItemAlias = array_shift($urlComponents)) && isset($cache[$contentItemID][$contentItemAlias])) {
				$contentItemID = $cache[$contentItemID][$contentItemAlias];
				$count++;
			}

			// content item is valid
			if ($contentItemID != $rootID && ($numberOfUC == $count || $this->getFilename() && ($numberOfUC - 1) == $count)) {
				return array($contentItemID, $rootID);
			}
			// content item does not exist
			else {
				return array(0, $rootID);
			}
		}
		// no content item specified
		else {
			// try to guess the desired language for new sessions
			if (WCF::getSession()->isNew) {
				$languageID = ContentItem::getInitialRootLanguageID();
			}
			// use the language of the active session otherwise
			else {
				$languageID = WCF::getSession()->getLanguageID();
			}

			// get root based on the determined language
			$rootID = ContentItem::getRootIDByLanguageID($languageID);
			$rootURL = ContentItem::getContentItem($rootID)->getURL();

			// redirect to the index page of the root
			if ($rootURL != URL_PREFIX) {
				if (!defined('NO_REDIRECTS')) {
					HeaderUtil::sendNoCacheHeaders();
					HeaderUtil::redirect($rootURL.SID_ARG_1ST);
					exit;
				}
				else {
					return;
				}
			}

			$contentItemID = ContentItem::getIndexContentItemID($rootID);
			return array($contentItemID, $rootID);
		}
	}

	/**
	 * Returns the request language id.
	 *
	 * @return	integer
	 */
	public function getLanguageID() {
		if ($this->languageID === null) {
			$this->languageID = WCF::getSession()->getLanguageID();

			// get language id of root
			$rootID = $this->getRootID();
			if ($rootID) {
				$this->languageID = ContentItem::getContentItem($rootID)->languageID;
				WCF::getSession()->setLanguageID($this->languageID);
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
			throw new MOXEOPermissionDeniedException();
		}
		catch (IllegalLinkException $e) {
			throw new MOXEOIllegalLinkException();
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