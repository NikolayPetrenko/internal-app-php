class uploader
  options: 
    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
    url      : SYS.baseUrl + "uploader/temp"
    dataType : 'json'
    
  constructor: (o) ->
    $.extend @, o
    do @init
    
  init: ->
    @selector.fileupload @options
    
    @selector.bind 'fileuploadadd', (e, data) ->
      $(@).data('fileupload')._trigger('sent', e, data)
      @addCallback?(e, data)

    @selector.bind 'fileuploadprogress', (e, data) =>
      progress = parseInt(data.loaded / data.total * 100, 10)
      @progressCallback?(progress)
    
    @selector.bind 'fileuploaddone', (e, data) =>
      @doneCallback?(e, data)



class Alert
  status : "success"
  strong : "Well done!"
  message: ""
  
  prepend_selector: $('div.main')
  setStatus: (status) ->
    @status = status
    switch status
      when ("success")
        @strong = "Исполнено!"
      when ("error")
        @strong = "Не получится!"
      when ("info")
        @strong = "Уведомление!"
      else
        @strong = "Уведомление!"
    @
  
  @hideAll: ->
    $(".alert").remove()

  @factory: ->
    new Alert
  
  setLayout: (layout) ->
    switch layout
      when ("main")
        @prepend_selector = ".my-container"
      when ("admin")
        @prepend_selector = ".span8"
    @

  setMessage: (message) ->
    @message = message
    @

  render: ->
    $(".alert").remove()
    html = "<div class=\"alert alert-" + @status + "\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>" + @strong + "</strong> " + @message + "</div>"
    $(@prepend_selector).prepend html   
    
    
$(document).ready ->
  new_test_form = $ '.newTest'
  name = new_test_form.find '.input-medium'
  submit = new_test_form.find '.btn'
  new_test_form.submit (e) ->
    e.preventDefault()
    submit.attr('disabled', true)
    new_test_form[0].submit()
  
  name.keyup (e) =>
    name_text = $(e.target).val()
    if name_text.trim() isnt ''
      submit.removeAttr('disabled')
    else
      submit.attr('disabled', true)
      
  new_sub_test = $ '.newSubTest'
  name_test = new_sub_test.find '.input-big'
  name_test.keyup (e)=>
    name_test_text = $(e.target).val()
    submit_t = $(e.target).next '.btn'
    if name_test_text.trim() isnt ''
      submit_t.removeAttr('disabled')
    else
      submit_t.attr('disabled', true)