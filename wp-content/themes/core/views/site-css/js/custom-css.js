(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		var cssEditor = ace.edit('fsm_site_css');
        cssEditor.getSession().setMode('ace/mode/css');
        cssEditor.setValue($('textarea[name="fsm_site_css"]').html(), -1);
		
		var headEditor = ace.edit('fsm_head_includes');
        headEditor.getSession().setMode('ace/mode/html');
        headEditor.setValue(($('textarea[name="fsm_head_includes"]').text()), -1);
		
        $('form.fsm_site_styling').on('submit', function(){
            $('textarea[name="fsm_site_css"]').html(cssEditor.getValue());
            $('textarea[name="fsm_head_includes"]').html('');
            $('textarea[name="fsm_head_includes"]').text(headEditor.getValue());
        });
        
	});
	
})(jQuery, this);
