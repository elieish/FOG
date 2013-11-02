/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.toolbar = 'MyToolbar';
    config.skin = 'kama';
    config.toolbarCanCollapse = false;
    config.autoGrow_maxHeight = 0;
    config.forcePasteAsPlainText = true;
    config.fullPage = true;
    config.resize_enabled = false;
    config.removePlugins = 'elementspath';
    config.extraPlugins = 'autogrow';
    config.toolbar_MyToolbar =
    [
	['NewPage'],
	['Font','FontSize'],
	['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['Table','HorizontalRule','SpecialChar','ImageButton'],
	'/',
	['Bold','Italic','Underline','Strike','Subscript','Superscript'],
	['TextColor','BGColor'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	['Cut','Copy','Paste','-'],
	['Link','Unlink'],
	['Source']
	






    ];    
};
