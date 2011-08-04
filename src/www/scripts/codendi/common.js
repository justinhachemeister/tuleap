/**
 * Copyright (c) Xerox Corporation, Codendi Team, 2001-2009. All rights reserved
 *
 * This file is a part of Codendi.
 *
 * Codendi is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Codendi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Codendi. If not, see <http://www.gnu.org/licenses/>.
 */

function help_window(helpurl) {
    var HelpWin = window.open(helpurl, 'HelpWindow', 'scrollbars=yes,resizable=yes,toolbar=no,height=740,width=1000');
    HelpWin.focus();
}

//http://mir.aculo.us/2009/1/7/using-input-values-as-hints-the-easy-way
(function(){
    var methods = {
        defaultValueActsAsHint: function (element) {
            element = $(element);
            element._default = element.value;
            
            return element.observe('focus', function (){
                if (element._default !== element.value) { 
                    return; 
                }
                element.removeClassName('hint').value = '';
            }).observe('blur', function (){
                if (element.value.strip() !== '') { 
                    return; 
                }
                element.addClassName('hint').value = element._default;
            }).addClassName('hint');
        }
    };
   
  $w('input textarea').each(function(tag){ Element.addMethods(tag, methods); });
})();

var codendi = codendi || { };

codendi.imgroot = codendi.imgroot || '/themes/common/images/';

codendi.locales = codendi.locales || { };

codendi.getText = function(key1, key2) {
    return codendi.locales[key1][key2];
};

codendi.feedback = {
    log: function (level, msg) {
        var feedback = $('feedback');
        if (feedback) {
            var current = null;
            if (feedback.childElements().size() && (current = feedback.childElements().reverse(0)[0]) && current.hasClassName('feedback_' + level)) {
                current.insert(new Element('li').update(msg));
            } else {
                feedback.insert(new Element('ul').addClassName('feedback_'+level).insert(new Element('li').update(msg)));
            }
        } else {
            alert(level + ': ' + msg);
        }
    },
    clear: function () {
        var feedback = $('feedback');
        if (feedback) {
            feedback.update('');
        }
    }
};


document.observe('dom:loaded', function () {
    
    $$('td.matrix_cell').each(function (cell) {
        var idx = cell.previousSiblings().length;
        var col = cell.up('table').down('tbody').childElements().collect(function (tr) {
            return tr.childElements()[idx];
        });
    });
});
