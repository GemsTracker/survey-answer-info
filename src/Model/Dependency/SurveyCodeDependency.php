<?php

/**
 *
 *
 * @package    Pulse
 * @subpackage Model\Dependency
 * @author     Jasper van Gestel <jvangestel@gmail.com
 * @copyright  Copyright (c) 2014 Equipe Zorgbedrijven BV
 * @license    Not licensed, do not copy
 * @version    $Id: DyfoAnswerDependency.php $
 */

namespace Gems\SurveyAnswerInfo\Model\Dependency;

use MUtil\Model\Dependency\DependencyAbstract;

/**
 *
 *
 * @package    Pulse
 * @subpackage Model\Dependency
 * @copyright  Copyright (c) 2014 Equipe Zorgbedrijven BV
 * @license    Not licensed, do not copy
 * @since      Class available since version 1.7.2 5-nov-2015 16:45:39
 */
class SurveyCodeDependency extends DependencyAbstract
{
    /**
     * Array of setting => setting of setting changed by this dependency
     *
     * The settings array for those effecteds that don't have an effects array
     *
     * @var array
     */
    protected $_defaultEffects = ['multiOptions'];

    /**
     *
     * @var \Gems_Loader
     */
    protected $loader;

    protected $locale;

    /**
     *
     * @var \Gems_Util
     */
    protected $util;

    /**
     * Returns the changes that must be made in an array consisting of
     *
     * <code>
     * array(
     *  field1 => array(setting1 => $value1, setting2 => $value2, ...),
     *  field2 => array(setting3 => $value3, setting4 => $value4, ...),
     * </code>
     *
     * By using [] array notation in the setting name you can append to existing
     * values.
     *
     * Use the setting 'value' to change a value in the original data.
     *
     * When a 'model' setting is set, the workings cascade.
     *
     * @param array $context The current data this object is dependent on
     * @param boolean $new True when the item is a new record not yet saved
     * @return array name => array(setting => value)
     */
    public function getChanges(array $context, $new)
    {
        $empty      = $this->util->getTranslated()->getEmptyDropdownArray();
        $inputFieldName  = reset($this->_dependentOn);
        $surveyId   = $context[$inputFieldName];

        if ($surveyId) {

            $survey = $this->loader->getTracker()->getSurvey($surveyId);
            if ($survey instanceof \Gems_Tracker_Survey) {
                $questionList = $survey->getQuestionList($this->locale);

                $questions = array();
                foreach($questionList as $questionCode=>$question) {
                    $questions[$questionCode] = $questionCode;
                }
                //\MUtil_Echo::track($this->_effecteds);
                foreach($this->_effecteds as $effectedField=>$effectedData)  {
                    foreach($effectedData as $type) {
                        $output[$effectedField][$type] = $empty + $questions;
                    }
                }


                return $output;
            }
        }
    }
}
