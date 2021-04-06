<?php

namespace Gems\SurveyAnswerInfo\Controller;

class SurveyAnswerInfoController extends \Gems_Controller_ModelSnippetActionAbstract
{
    public $db;

    public $locale;

    public $request;

    public $util;

    public function createModel($detailed, $action)
    {
        $model = new \Gems\SurveyAnswerInfo\Model\SurveyAnswerInfoModel();
        $this->loader->applySource($model);
        if ($detailed) {
            $model->applyBrowseSettings();
        } else {
            $model->applyBrowseSettings();
        }

        return $model;
    }
}
