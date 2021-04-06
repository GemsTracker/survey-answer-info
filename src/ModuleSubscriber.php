<?php


namespace Gems\SurveyAnswerInfo;

use Gems\Event\Application\GetDatabasePaths;
use Gems\Event\Application\MenuAdd;
use Gems\Event\Application\SetFrontControllerDirectory;
use Gems\Event\Application\ZendTranslateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ModuleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            GetDatabasePaths::NAME => [
                ['getDatabasePaths'],
            ],
            MenuAdd::NAME => [
                ['addToMenu']
            ],
            SetFrontControllerDirectory::NAME => [
                ['setFrontControllerDirectory'],
            ],
        ];
    }

    public function addToMenu(MenuAdd $event)
    {
        $menu = $event->getMenu();
        $translateAdapter = $event->getTranslatorAdapter();

        $trackBuilder = $menu->findController('source')->getParent();

        $trackBuilder->addBrowsePage($translateAdapter->_('Survey answer info'), 'pr.survey-answer-info', 'survey-answer-info');

    }

    public function getDatabasePaths(GetDatabasePaths $event)
    {
        $path = ModuleSettings::getVendorPath() . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'db';
        $event->addPath(ModuleSettings::$moduleName, $path);
    }

    public function setFrontControllerDirectory(SetFrontControllerDirectory $event)
    {
        $applicationPath = ModuleSettings::getVendorPath() . DIRECTORY_SEPARATOR . 'controllers';
        $event->setControllerDirIfControllerExists($applicationPath);
    }
}
