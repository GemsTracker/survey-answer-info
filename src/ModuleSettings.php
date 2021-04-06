<?php


namespace Gems\SurveyAnswerInfo;

use Gems\Modules\ModuleSettingsAbstract;

class ModuleSettings extends ModuleSettingsAbstract
{
    public static $moduleName = 'Gems\\SurveyAnswerInfo';

    public static $eventSubscriber = ModuleSubscriber::class;
}
