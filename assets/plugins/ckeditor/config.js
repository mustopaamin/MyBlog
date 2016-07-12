/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
		config.extraPlugins = 'readmore,fakeobjects,codesnippet,dialog,widget,lineutils,wordcount,notification,uploadimage,uploadwidget,filetools,notificationaggregator';
		config.wordcount = {
		    // Whether or not you want to show the Word Count
		    showWordCount: false,
		    // Whether or not you want to show the Char Count
		    showCharCount: true,
		    // Maximum allowed Word Count
		    maxWordCount: 20000,
		    // Maximum allowed Char Count
		    maxCharCount: 50000
		};
};
