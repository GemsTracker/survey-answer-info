# Gemstracker Survey answer info
Add a place to store info about survey answers

**Requires** PHP 7.0+

## Installation
1. Add to composer.json of project, including adding the repository
2. composer update
3. Register your module in your Projects Escort by adding the following static property:
```PHP
    public static $modules = [
        'gemstracker\surey-answer-info' => \Gems\SurveyAnswerInfo\ModuleSettings::class,
    ];
```
