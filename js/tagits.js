var types = {
    init: function(){
        this.initTagit();
        this.maskInput();
        var tr = $('.newSubTest').parents('td').parent('tr');
        tr.find('td').css('background-color', '#fff');
        this.takeTestInit(); 
        this.deleteTest();
        this.deleteSubTest();
        this.addNewSubtest();
        this.editNameTestInit();
        this.editNameSubtestInit();
    },

    editNameTestInit: function(){
        var edit = $('.main').find('h3');
        edit.dblclick(function(e){
            var $this = $(this);
            e.preventDefault();
            var proto = _.template($('#edit-name-test').html(), {el: {text: $this.html(), id: $this.data('id')}});
            $this.after(proto);
            var id = $this.data('id');
            $this.remove();
            types.notEmptyInput($('.edit-name'));
            types.editNameTest(id);
        });
    },

    editNameSubtestInit: function(){
        var edit = $('.subtest-name');
        edit.dblclick(function(e){
            var $this = $(this);
            e.preventDefault();
            var proto = _.template($('#edit-name-subtest').html(), {text: $this.html(), level: $this.parents('tr').data('level'), category: $this.data('category')});
            $this.after(proto);
            $this.remove();
            types.notEmptyInput($('.edit-name'));
            types.editNameSubtest();
        });
    },

    editNameSubtest: function(){
        $('.editNameSubtest').on('submit', function(e){
            e.preventDefault();
            var $this = $(this);
            $this.find('.btn').attr('disabled', true);
            $this.ajaxSubmit({
                success: function(responseText, statusText, xhr, $form){
                    $this.after('<div data-category="' + responseText.data.category + '" class="subtest-name">' + responseText.data.name + '</div>');
                    var parent = $this.parents('tr');
                    $(parent).data('level', responseText.data.level);

                    $(parent).find('.link-url').attr('href', SYS.baseUrl + 'admin/tests/add/'+responseText.data.category+'/'+responseText.data.level);
                    $(parent).find('.deleteSubTest').attr('action', SYS.baseUrl + 'admin/tests/deletesub/'+responseText.data.category+'/'+responseText.data.level);
                    $(parent).find('.generateSubTest').attr('action', SYS.baseUrl + 'admin/tests/generate/'+responseText.data.category+'/'+responseText.data.level);

                    $this.remove();
                    types.editNameSubtestInit();
                    if(responseText.errors.length == 0){
                        Alert.factory().setMessage("Название подтеста успешно изменено!").render();
                    }
                }
            });
        });
    },
    
    editNameTest: function(id){
        $('.editNameTest').on('submit', function(e){
            e.preventDefault();
            var $this = $(this);
            $this.find('.btn').attr('disabled', true);
            $this.ajaxSubmit({
                success: function(responseText, statusText, xhr, $form){
                    $this.after('<h3 data-id="' + id + '">' + $this.find('.edit-name').val() + '</h3>');
                    $this.remove();
                    types.editNameTestInit();
                    if(responseText.errors.length == 0){
                        Alert.factory().setMessage("Название теста успешно изменено!").render();
                    }
                }
            });
        });
    },

    notEmptyInput: function(input){
        input.keyup(function(){
            var button = $(this).parent().find('.btn');
            if($(this).val().trim() != '')
              button.removeAttr('disabled');
            else
              button.attr('disabled', true);
        });
    },

    addNewSubtest: function(){
        $('.newSubTest').on('submit', function(e){
           e.preventDefault();
           var $this = this;
           $($this).find('.btn').attr('disabled', true);
           $($this).ajaxSubmit({
               success: function(responseText, statusText, xhr, $form){
                   var res = jQuery.parseJSON(responseText);
                   var html = _.template($('#subtest-template').html(), {level: {id: res.data.level.id, name: res.data.level.name}, category_id: res.data.category_id});
                   $($this).parents('tr').before(html);
                   $($this).find('.input-big').val('');
                   types.initTagit();
                   types.deleteSubTest();
                   Alert.factory().setMessage("Подтест успешно добавлен!").render();
               }
           });
        });
    },

    deleteSubTest: function(){
        $('.deleteSubTest').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var tr = form.parents('tr');
            var subTests = tr.parents('table').find('.subTest');
            $(this).ajaxSubmit({
                success: function(){
                    if(subTests.length == 1){
                        tr.html('<td>No Subtests</td><td style="border-left: #f9f9f9"></td><td style="border-left: #f9f9f9"></td><td style="border-left: #f9f9f9"></td>');
                    }else{
                        tr.remove();
                    }
                    $("tr:odd").addClass("odd");
                    Alert.factory().setMessage("Подтест успешно удален!").render();
                }
            })
        });         
    },

    deleteTest: function(){
        $('.deleteTest').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var head = $(this).prev('h3');
            var table = $(this).next('table');
            $(this).ajaxSubmit({
                success: function(){
                    form.hide();
                    head.hide();
                    table.hide();
                    Alert.factory().setMessage("Тест успешно удален!").render();
                }
            })
        }); 
    },

    takeTestInit: function(){
        $('.take').click(function(e){
            e.preventDefault();
            var form = $(this).parent('form');
            if($(this).is('.generate')){
                form.children('input[name="take"]').val(0);
            }else{
                form.children('input[name="take"]').val(1);
            }
            form.submit();
        });
    },

    maskInput: function(){
        $('input[name="question_count"]').numberMask();
    },

    initTagit: function(){
        $('.categories-select').tagit({
            removeConfirmation: true, 
            allowSpaces: true, 
            tagSource: function(req, response){
                $.ajax({
                        url: SYS.baseUrl + 'admin/tests/get_type_category', 
                        data: {term:req.term},
                        type: 'POST',
                        dataType: "json",
                        success: function( data ) {
                            response( $.map( data.data, function( item ) {
                                return {
                                    label: item.value
                                }
                            }));
                        }
                });
            }, 
            afterTagAdded: function(event, ui) {
                if($(ui.tag).is('.old')) return false;
                types.actionType($(ui.tag), 'added');
            },
            beforeTagRemoved: function(event, ui) {
                if($(ui.tag).is('.general')) return false;
                if(confirm('Удалить категорию?')){
                    types.actionType($(ui.tag), 'remove');
                }else{
                    return false;
                }
            } 
        });
    },

    actionType: function(el, action){
        var name = el.find('.tagit-label').html();
        var category =el.parents('table').data('category');
        var level =el.parents('tr').data('level');
        el.addClass('old');
        $.ajax({
            url: SYS.baseUrl + 'admin/tests/ajaxActionType', 
            data: {
                name          :  name,
                category : category,
                level        : level, 
                action      : action
            },
            type: 'POST',
            dataType: "json",
            success: function() {
            }
        });
    }
};

//init our object
$(function() {
     types.init();
});