<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Generates and manages captchas.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.captcha
 * @category	Infinite Site
 */
class Captcha extends DatabaseObject {
	/**
	 * Creates a new Captcha object.
	 * 
	 * @param	integer		$captchaID
	 * @param 	array<mixed>	$row
	 */
	public function __construct($captchaID, $row = null) {
		if ($captchaID !== null) {
			$sql = "SELECT	*
				FROM 	wsis".WSIS_N."_captcha
				WHERE 	captchaID = ".$captchaID;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		parent::__construct($row);
	}
	
	/**
	 * Returns the question of this captcha.
	 * 
	 * @return	string
	 */
	public function getQuestion() {
		return WCF::getLanguage()->getDynamicVariable('wsis.captcha.question.question'.$this->questionNo, array('firstValue' => $this->firstValue, 'secondValue' => $this->secondValue));
	}
	
	/**
	 * Returns the encoded question.
	 * 
	 * @return	string
	 */
	public function getEncodedQuestion() {
		$question = $this->getQuestion();
		return StringUtil::encodeAllChars($question);
	}
	
	/**
	 * Validates the given captcha value.
	 * 
	 * @param	integer		$captchaValue
	 */
	public function validate($captchaValue) {
		try {
			if (!$this->captchaID) {
				throw new UserInputException('captchaValue');
			}
			
			if (empty($captchaValue)) {
				throw new UserInputException('captchaValue');
			}
			
			if ($captchaValue != ($this->firstValue + $this->secondValue)) {
				throw new UserInputException('captchaValue', 'false');
			}
			
			$this->delete();
		}
		catch (Exception $e) {
			$this->delete();
			throw $e;
		}
	}
	
	/**
	 * Deletes this captcha.
	 */
	public function delete() {
		if ($this->captchaID) {
			$sql = "DELETE FROM	wsis".WSIS_N."_captcha
				WHERE		captchaID = ".$this->captchaID;
			WCF::getDB()->sendQuery($sql);
		}
	}
	
	/**
	 * Creates a new Captcha.
	 * 
	 * @return	integer
	 */
	public static function create() {
		$questionNo = MathUtil::getRandomValue(1, 3);
		$firstValue = MathUtil::getRandomValue(1, 10);
		$secondValue = MathUtil::getRandomValue(1, 10);
		
		// save new captcha
		$sql = "INSERT INTO	wsis".WSIS_N."_captcha
					(questionNo, firstValue, secondValue, time)
			VALUES		(".$questionNo.", ".$firstValue.", ".$secondValue.", ".TIME_NOW.")";
		WCF::getDB()->sendQuery($sql);
		return WCF::getDB()->getInsertID("wsis".WSIS_N."_captcha", 'captchaID');		
	}
}
?>