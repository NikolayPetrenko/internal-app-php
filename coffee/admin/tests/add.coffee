qestion = 
  init: ->
    
  showModal: (question_id) ->
    modal = $ '#questionModal'
    $.ajax
      url : SYS.baseUrl + 'admin/tests/get_form_question'
      type: 'POST'
      dataType: 'JSON'
      data: $.param
        question_id: question_id
      success: (res) ->
        if res.text is 'success'
          modal.find('.modal-body').html(res.data.form_question)
          window.question = new QuestionBuilder $('#question-edit')
          $('.delete-image').unbind "click"
          $('.delete-image').click (e) =>
            btn = $(e.target)
            img = btn.prev('.question-img-container')
            img.attr("src", SYS.baseUrl+'img/white.jpg')
            btn.parents('.add_q').find("input[name='question[image]']").val('')
            btn.hide()
          $('.answers_container').find('div.row').each (key, el) =>
            new_answer = new Answer $(el)
            do new_answer.bindAfter
          if question.getQuestionType() is 'write'
            question.elemets.section_answers.hide()
          modal.on "show", ->
            $('.fixed').css({display:"block"});
            $('body').css({overflow:"hidden"});
            $('.modal-backdrop').show()
          modal.modal()
          modal.on "hide", ->
            $('.modal-backdrop').hide()
            window.question = new QuestionBuilder $('#question-form')
            modal.find('.modal-body').html('')
            
  move: (question_id, level_id , el) ->  
    if confirm "Переместить вопрос?"
      $.ajax
        url : SYS.baseUrl + 'admin/tests/move_qestion'
        type: 'POST'
        dataType: 'JSON'
        data: $.param
          question_id: question_id
          level_id   : level_id
          
        success: (res) ->
          if res.text is 'success'
            $(el).parents('div.question').fadeOut('fast')
            Alert.factory().setMessage("Вопрос успешно перемещен!").render()

  remove: (question_id, el) ->
    if confirm "Удалить вопрос?"
      $.ajax
        url : SYS.baseUrl + 'admin/tests/remove_qestion'
        type: 'POST'
        dataType: 'JSON'
        data: $.param
          question_id: question_id
        success: (res) ->
          if res.text is 'success'
            $(el).parents('div.question').fadeOut('fast')
            Alert.factory().setMessage("Вопрос успешно удален!").render()
          
          
      



$(document).ready ->
  do qestion.init
  window.question = new QuestionBuilder $("#question-form")
  $('.answers_container').find('div.row').each (key, el) =>
    new_answer = new Answer $(el)
    do new_answer.bindAfter