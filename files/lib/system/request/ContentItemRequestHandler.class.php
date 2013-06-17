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
			// define url prefix
			define('URL_PREFIX', (ENABLE_SEO_REWRITING ? '' : 'index.php/'));

			list($this->contentItemID, $this->rootID) = $this->getContentItemDataByBasename($this->getBasename());
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
	protected function getContentItemDataByBasename($basename) {
		// get request components
		$requestComponents = array();
		if ($basename) {
			$requestComponents = explode('/', $basename);
			if (!ENABLE_SEO_REWRITING) {
				array_shift($requestComponents);
			}
		}

		// get content item id
		if (($numberOfRC = count($requestComponents))) {
			$contentItemID = 0;
			$cache = WCF::getCache()->get('contentItemAlias');

			// request with one component
			if ($numberOfRC == 1 && isset($cache[$contentItemID][$requestComponents[0]])) {
				$rootID = $cache[$contentItemID][$requestComponents[0]];

				// check if this component is a root
				if (ContentItem::getContentItem($rootID)->isRoot()) {
					Language::$cache = WCF::getCache()->get('languages');
					$contentItemID = ContentItem::getIndexContentItemID($rootID);

					// return if root has no accessible children
					if (!$contentItemID) {
						return array(0, $rootID);
					}
				}
			}

			// try to find content item id
			if (!$contentItemID) {
				$rootID = 0;

				// if request component doesn't match, request component might be the alias of a child of the super root
				if (!isset($cache[$contentItemID][$requestComponents[0]])) {
					$rootID = ContentItem::getSuperRootID();
				}

				// process request components
				$contentItemID = $rootID;
				$count = 0;
				while (($contentItemAlias = array_shift($requestComponents)) && isset($cache[$contentItemID][$contentItemAlias])) {
					$contentItemID = $cache[$contentItemID][$contentItemAlias];
					$count++;
				}

				if ($contentItemID != $rootID && $numberOfRC <= $count) {
					return array($contentItemID, ContentItem::getContentItem($contentItemID)->getRootID());
				}
				else {
					return array(0, ContentItem::getContentItem($contentItemID)->getRootID());
				}
			}
			else {
				return array($contentItemID, ContentItem::getContentItem($contentItemID)->getRootID());
			}
		}
		else {
			// find root page with empty alias
			$rootID = ContentItem::getSuperRootID();

			$languageID = 0;
			if ($rootID) {
				Language::$cache = WCF::getCache()->get('languages');

				// try to guess the desired language on new sessions
				if (WCF::getSession()->isNew) {
					$languageID = ContentItem::getInitialRootLanguageID();
				}
			}
			if (!$languageID) {
				$languageID = WCF::getSession()->getLanguageID();
			}

			// get root based on the determined language
			$rootID = ContentItem::getRootIDByLanguageID($languageID);
			$rootURL = ContentItem::getContentItem($rootID)->getURL();

			// redirect to the index page of the root
			if ($rootURL != '/') {
				HeaderUtil::sendNoCacheHeaders();
				HeaderUtil::redirect($rootURL.SID_ARG_1ST);
				exit;
			}

			$contentItemID = ContentItem::getIndexContentItemID($rootID);
			return array($contentItemID, ContentItem::getContentItem($contentItemID)->getRootID());
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