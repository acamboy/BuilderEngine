/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';asdasd
	config.extraPlugins = "sourcedialog";
	config.language = 'en';
	config.language_list = [ 'en:English' ];
	config.skin = 'icy_orange';
	config.extraPlugins = 'ckeditor-gwf-plugin';
	config.font_names = 'GoogleWebFonts;' +
	'Arial/Arial, Helvetica, sans-serif;' +
	'Comic Sans MS/Comic Sans MS, cursive;' +
	'Courier New/Courier New, Courier, monospace;' +
	'Georgia/Georgia, serif;' +
	'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
	'Tahoma/Tahoma, Geneva, sans-serif;' +
	'Times New Roman/Times New Roman, Times, serif;' +
	'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
	'Verdana/Verdana, Geneva, sans-serif';
   config.filebrowserBrowseUrl = site_root + '/admin/files/show/embedded';
   config.filebrowserImageBrowseUrl = site_root + '/admin/files/show/embedded/?type=Images';
   config.filebrowserFlashBrowseUrl = site_root + '/admin/files/show/embedded/?type=Flash';
   /*config.filebrowserUploadUrl = '/admin/files/connector?cmd=upload&type=Files';
   config.filebrowserImageUploadUrl = '/admin/files/connector?cmd=upload&type=Images';
   config.filebrowserFlashUploadUrl = '/admin/files/connector?cmd=upload&type=Flash';*/
   config.allowedContent = true;
   config.protectedSource.push(/<i[^>]*><\/i>/g);
   config.protectedSource.push(/<img[^>]*><\/img>/g);
   CKEDITOR.dtd.$removeEmpty['i'] = false;
};
