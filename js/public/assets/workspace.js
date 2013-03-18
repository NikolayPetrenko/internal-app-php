(function(){
window.JST = window.JST || {};

window.JST['answer'] = _.template('<div class="row">\n        <div class="span8 control-group"><textarea class="qopt" name="question[answers][<%= key %>][text]" id="" cols="30" rows="10"></textarea></div>\n        <div class="span3"><span class="btn btn-mini remove-answer">Удалить</span><label><input name="question[answers][<%= type == \'checkbox\' ? key : \'radio\' %>][corrected]" class="correct-answers" value="1"  type="<%= type %>"> Правильный ответ</label></div>\n</div>');
})();