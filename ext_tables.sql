
CREATE TABLE tx_course_domain_model_course (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	# lizenz
	address int(11) DEFAULT '0' NOT NULL,
	number varchar(255) DEFAULT '' NOT NULL,
	additional_text text,
	course_start_date int(11) unsigned DEFAULT '0' NOT NULL,
	course_end_date int(11) unsigned DEFAULT '0' NOT NULL,
	link_for_agb varchar(255) DEFAULT '' NOT NULL,

	course_type varchar(255) DEFAULT '' NOT NULL,
	course_description text,
	course_index varchar(255) DEFAULT '' NOT NULL,

	costs varchar(255) DEFAULT '' NOT NULL,
	costs_text varchar(255) DEFAULT '' NOT NULL,
	currency varchar(255) DEFAULT 'EUR' NOT NULL,
	available_places varchar(255) DEFAULT '' NOT NULL,

	link_for_registration varchar(255) DEFAULT '' NOT NULL,

	categories int(11) DEFAULT '0' NOT NULL,

	import_id varchar(100) DEFAULT '' NOT NULL,
	import_source varchar(100) DEFAULT '' NOT NULL,

	path_segment varchar(2048),

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state smallint(6) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid),
	KEY number (number),
	KEY importer(import_source,import_id),
	UNIQUE KEY number_pid (number,pid)
);

#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (
	import_id varchar(100) DEFAULT '' NOT NULL,
	import_source varchar(100) DEFAULT '' NOT NULL,

	KEY importer(import_source,import_id)
);
