class QuestionBuilder

  question:
    type: ''

  constructor: (@form) ->
    do @_detectElements
    do @_init
    do @_bindEvents
    
  _init: ->
    do @_detectType
    @renderAnswers @question.type

  _detectType    : -> @question.type = do @getQuestionType
  _detectElements: ->
    @controls = 
      qestion_type     : @form.find '.qestion-type'
      add_answer       : @form.find '.add-answer'
      start_upload     : @form.find '.question-upload'
      submit           : @form.find 'input[type=submit]'
      edit             : @form.find '#editquestion'

    @elemets  =
      section_answers         : @form.find '.testanswers'
      answers_container       : @form.find '.answers_container'
      question_img_container  : @form.find '.question-img-container'
      qestion_container       : $ 'section.questions'

  _bindEvents: ->
    do @_initValidation
    do @_initUploader
    @controls.qestion_type.change =>
      @question.type = do @getQuestionType
      switch @question.type
        when 'write'    then do @removeAnswersContainer
        when 'checkbox' then @renderAnswers 'checkbox'
        when 'radio'    then @renderAnswers 'radio'
      false
    
    @controls.add_answer.unbind "click" 
    @controls.add_answer.click (e) =>
      count = $('.qopt').length
      new_answer = Answer.factory()
      @elemets.answers_container.append new_answer.el
      new_answer.el.find('.qopt').attr('name', 'question[answers]['+count+'][text]')
      do new_answer.bindAfter
      false
     
    @controls.edit.unbind "click" 
    @controls.edit.click (e) =>
      if @form.valid()
        do @_editData
      false
    
    @controls.submit.unbind "click" 
    @controls.submit.click (e) =>
      if @form.valid()
        do @_saveData
      false

  _editData: () ->
    $.ajax
      url: "#{SYS.baseUrl}admin/tests/save_qestion"
      type: "POST"
      data: @form.serialize()
      dataType: 'json'
      success: (res) =>
        $('[data-id="'+@form.find('input[name="question[id]"]').val()+'"]').remove()
        @elemets.qestion_container.prepend res.data.question
        $('.modal-backdrop').hide();
        $('body').css({overflow:"auto"});
        $('.fixed').fadeOut(); 
        Alert.factory().setMessage("Вопрос успешно изменен!").render()

  _saveData: (data) ->
    $.ajax
      url: "#{SYS.baseUrl}admin/tests/save_qestion"
      type: "POST"
      data: @form.serialize()
      dataType: 'json'
      success: (res) =>
        @elemets.qestion_container.prepend res.data.question
        Alert.factory().setMessage("Вопрос успешно добавлен!").render()
        @form.trigger 'reset' 
        @controls.qestion_type.trigger 'change'
        $.each $(".testanswers").find('.row'), (key, value) ->
          if key > 1
            $(this).remove()
        $(".success").removeClass('success')

  _initUploader: ->
    new uploader 
      selector   : @controls.start_upload
      addCallback: (e, data) =>
        #@fildset.find('.visa-scan-img').attr 'src', SYS.spinerUrl

      doneCallback: (e, data) =>
        @elemets.question_img_container.attr 'src', SYS.baseUrl + data.result.data.paste
        @form.find("input[name='question[image]']").val data.result.data.name
        $('.delete-image').show()

      progressCallback: (progress) =>

  _initValidation: ->
    @form.validate
      success   : (label) => 
        $(label).closest(".control-group").removeClass("error").addClass("success")
      highlight : (label) => 
        $(label).closest(".control-group").removeClass("success").addClass("error")

    @form.find('textarea.question').rules "add", required: true

  getQuestionType: ->
    @controls.qestion_type.find('option:selected').val()

  getAnswersCount: ->
    @elemets.answers_container.find('div.row').length

  removeAnswersContainer: ->
    @controls.add_answer.hide()
    @elemets.answers_container.parent().hide()

  getCorrectAnswersElemets: ->
    @elemets.answers_container.find('.correct-answers')

  renderAnswers: (answersType) ->
    @controls.add_answer.show()
    @elemets.answers_container.parent().show()
    @getCorrectAnswersElemets().each (key, el) =>
      el.type = answersType
      switch answersType
       when 'checkbox'
        $(el).attr 'name', "question[answers][#{key}][corrected]"
       when 'radio'  
        $(el).attr 'name', "question[answers][radio][corrected]"

class Answer
  count   : 0
  template: JST['answer']

  constructor: (@el) ->
    do @render unless @el
    Answer::count++
    do @_detectElemets
    do @_bindElemets
    
  
  render: ->
    @el = $(@template({key:Answer::count, type:question.question.type}))
  
  _detectElemets: ->
    @controls =
      remove: @el.find('span.remove-answer')
    @fields =
      answer: @el.find('textarea.qopt')  

  _bindElemets: ->
    @controls.remove.click (e) =>
      if question.getAnswersCount() > 2
        @el.remove()
      else
        if $('#question-edit').find('input[name="question[id]"]').length isnt 0
          (new Alert).setLayout('#questionModal').setStatus('error').setMessage("Не меньше двух вариатов ответов!").render()
          alert = $ '.alert'
          $('.alert').remove()
          $('.modal-body').before(alert)
        else
          (new Alert).setStatus('error').setMessage("Не меньше двух вариатов ответов!").render()
      false
  
  bindAfter: ->
    @fields.answer.rules "add", required: true
    
  
  @factory: -> new Answer()