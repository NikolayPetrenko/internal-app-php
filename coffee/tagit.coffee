class Tagit

  constructor: () ->
    do @_init
    
  _init:->
    do @_maskInput
    do @_takeTestInit
    do @_initTagit
    do @_initZebra

  _initZebra: ->
    tr = $('.newSubTest').parents('td').parent('tr')
    tr.find('td').css('background-color', '#fff')    
    
  _maskInput: ->
    $('input[name="question_count"]').numberMask()

  _takeTestInit: ->
    $('.take'). click (e) ->
      e.preventDefault()
      $.cookie('test', 'juihmefdjs5dvg94d1toa1abl5')
      form = $(this).parent('form')
      if($(this).is('.generate'))
        form.children('input[name="take"]').val(0)
      else
        form.children('input[name="take"]').val(1)
      form.submit();

  _initTagit: ->
      $('.categories-select').tagit({
        removeConfirmation: true 
        allowSpaces: true 
        tagSource: (req, response) =>
          $.ajax
            url: SYS.baseUrl + 'admin/tests/get_type_category' 
            data: 
              term:req.term
            type: 'POST'
            dataType: "json"
            success: ( data ) =>
              response $.map(data.data, (item) =>
                label: item.value
              )
 
        afterTagAdded: (event, ui) =>
          if($(ui.tag).is('.old')) 
            return false
          do @_actionType($(ui.tag), 'added')

        beforeTagRemoved: (event, ui) =>
          if($(ui.tag).is('.general'))
            return false
          if(confirm('Удалить категорию?'))
            do @_actionType($(ui.tag), 'remove')
          else
            return false
      })

  _actionType: (el, action) ->
    name = el.find('.tagit-label').html()
    category =el.parents('table').data('category')
    level =el.parents('tr').data('level')
    el.addClass('old')
    $.ajax
      url: SYS.baseUrl + 'admin/tests/ajaxActionType', 
      data: 
        name          :  name,
        category : category,
        level        : level, 
        action      : action
      type: 'POST'
      dataType: 'json'
  
$(document).ready ->
  new Tagit