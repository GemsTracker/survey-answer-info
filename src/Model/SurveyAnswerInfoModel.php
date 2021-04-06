<?php

namespace Gems\SurveyAnswerInfo\Model;


use Gems\SurveyAnswerInfo\Model\Dependency\OrganizationTracksDependency;
use Gems\SurveyAnswerInfo\Model\Dependency\SurveyCodeDependency;
use Gems\SurveyAnswerInfo\Model\Transform\AddNullValuesToFilterTransformer;

class SurveyAnswerInfoModel extends \Gems_Model_JoinModel
{
    /**
     * @var \Zend_Db_Adapter_Abstract
     */
    protected $db;

    /**
     * @var \Gems_Loader
     */
    protected $loader;

    /**
     * @var \Gems_Util
     */
    protected $util;

    public function __construct()
    {
        parent::__construct('surveyAnswerInfo', 'gems__survey_answer_info', 'gsai', true);
    }

    protected function addDependencies()
    {
        $surveyCodeDependency = new SurveyCodeDependency();
        $this->loader->applySource($surveyCodeDependency);

        $this->addDependency($surveyCodeDependency, 'gsai_id_survey', ['gsai_question_code']);

        $organizationTracksDependency = new OrganizationTracksDependency();
        $this->loader->applySource($organizationTracksDependency);
        $this->addDependency($organizationTracksDependency, 'gsai_id_organization', ['gsai_id_track']);
    }

    protected function addTransformers()
    {
        $this->addTransformer(new AddNullValuesToFilterTransformer(
            [
                'gsai_id_organization',
                'gsai_id_track',
                'gsai_track_code',
                'gsai_id_survey',
                'gsai_survey_code',
            ]
        ));
    }

    public function applyBrowseSettings()
    {
        \MUtil_Model::$verbose = true;
        $translated = $this->util->getTranslated();
        $dbLookup = $this->util->getDbLookup();
        $empty = $translated->getEmptyDropdownArray();

        $organizations = $dbLookup->getOrganizations();

        $tracks = $this->util->getTrackData()->getActiveTracks();
        $trackCodes = $this->getTrackCodes();

        $surveys = $this->util->getTrackData()->getSurveysFor(null);
        $surveyCodes = $this->getSurveyCodes();

        $this->set('gsai_context',
            [
                'label' => $this->_('Context'),
                'description' => $this->_('The context in which this information is applicable'),
            ]
        );

        $this->set('gsai_id_organization',
            [
                'label' => $this->_('Organization'),
                'multiOptions' => $empty + $organizations,
            ]
        );

        $this->set('gsai_id_track',
            [
                'label' => $this->_('Track'),
                'multiOptions' => $empty + $tracks,
            ]
        );

        $this->set('gsai_track_code',
            [
                'label' => $this->_('Track code'),
                'multiOptions' => $empty + $trackCodes,
            ]
        );

        $this->set('gsai_id_survey',
            [
                'label' => $this->_('Survey'),
                'multiOptions' => $empty + $surveys,
            ]
        );

        $this->set('gsai_survey_code',
            [
                'label' => $this->_('Survey code'),
                'multiOptions' => $empty + $surveyCodes,
            ]
        );

        $this->set('gsai_question_code',
            [
                'label' => $this->_('Question code')
            ]
        );

        $this->set('gsai_info',
            [
                'label' => $this->_('Info'),
                'elementClass' => 'textarea'
            ]
        );

        $this->set('gsai_active',
            [
                'label' => $this->_('Active'),
                'multiOptions' => $translated->getYesNo(),
                'elementClass' => 'checkBox'
            ]
        );

        $this->addDependencies();
        $this->addTransformers();
    }

    /**
     * Get list of all codes used in tracks
     *
     * @return array
     */
    protected function getSurveyCodes()
    {
        $select = $this->db->select();
        $select->from('gems__surveys', ['gsu_code', 'code' => 'gsu_code'])
            ->where('gsu_code IS NOT NULL')
            ->where('gsu_active = 1')
            ->group('gsu_code');

        return $this->db->fetchPairs($select);
    }

    protected function getTrackCodes()
    {
        $select = $this->db->select();
        $select->from('gems__tracks', ['gtr_code', 'code' => 'gtr_code'])
            ->where('gtr_code IS NOT NULL')
            ->where('gtr_active = 1')
            ->group('gtr_code');

        return $this->db->fetchPairs($select);
    }
}
