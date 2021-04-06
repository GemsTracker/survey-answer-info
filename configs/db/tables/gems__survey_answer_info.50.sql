
CREATE TABLE if not exists gems__survey_answer_info (
        gsai_id                 bigint unsigned not null auto_increment,

        gsai_context            varchar(100) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' null,

        gsai_id_organization    int unsigned null references gems__organizations (gor_id_organization),

        gsai_id_survey          int unsigned null references gems__surveys (gsu_id_survey),
        gsai_survey_code        varchar(100) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' null,

        gsai_id_track           int unsigned null references gems__tracks (gtr_id_track),
        gsai_track_code         varchar(100) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' null,

        gsai_question_code      varchar(100) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' not null,

        gsai_info               text CHARACTER SET 'utf8' COLLATE 'utf8_general_ci',

        gsai_active             boolean not null default 1,

        gsai_changed            timestamp not null default current_timestamp on update current_timestamp,
        gsai_changed_by         bigint unsigned not null,
        gsai_created            timestamp not null default '0000-00-00 00:00:00',
        gsai_created_by         bigint unsigned not null,

        PRIMARY KEY (gsai_id)
    )
    ENGINE=InnoDB
    AUTO_INCREMENT = 1000
    CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';
