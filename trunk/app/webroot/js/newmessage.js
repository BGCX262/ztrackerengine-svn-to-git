    Ext.ux.TinyMCE.initTinyMCE();
    var newMsgForm = new Ext.form.FormPanel({
        bodyStyle: 'padding:5px 5px 0',
        baseCls: 'x-plain',
        frame: true,
        height: 200,
        labelWidth: 75,
        id: 'newMsgForm',
        url: 'sendmessage',
        defaultType:'textfield',

        items:[ {
            fieldLabel: 'Получатель',
            id: 'receiver',
            name: 'receiver',
            anchor:"100%"
        },{
            fieldLabel: 'Тема',
            id: 'subject',
            name: 'subject',
            anchor:"100%"
        }, { 
            xtype:"tinymce",
            anchor:"100%", 
            hideLabel: true,
            id: 'body',
            name: 'body',
            tinymceSettings:{
                    theme : "advanced",
                    plugins : "bbcode, emotions",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_buttons1 : "bold,italic,underline,undo,redo,emotions,link,unlink,image,forecolor,styleselect,removeformat,cleanup,code",
                    theme_advanced_buttons2 : "",
                    theme_advanced_buttons3 : "",
                    theme_advanced_toolbar_align : "center",
                    theme_advanced_styles : "Code=codeStyle;Quote=quoteStyle",
                    content_css : "css/bbcode.css",
                    entity_encoding : "raw",
                    add_unload_trigger : false,
                    remove_linebreaks : false,
                    inline_styles : false,
                    convert_fonts_to_spans : false
            },

        }],
    });

    var sendWindow = new Ext.Window({
        title: 'Новое сообщение',
        width: 500,
        height:300,
        minWidth: 300,
        minHeight: 200,
        layout: 'fit',
        closeAction: 'hide',
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'center',
        items: newMsgForm,

        buttons: [{
            text: 'Отправить',
            handler:function() {
                f = Ext.getCmp('newMsgForm').getForm();
                f.findField('body').syncValue();
                f.submit();
                sendWindow.hide(); }
        },{
            text: 'Отмена',
            handler:function() {
                f = Ext.getCmp('newMsgForm').getForm();
                f.reset();
                sendWindow.hide();
             }
        }]
    });
