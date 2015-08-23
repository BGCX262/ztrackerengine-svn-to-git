Ext.ux.TinyMCE.initTinyMCE();
Ext.onReady(function() {
    Ext.BLANK_IMAGE_URL="../img/s.gif";

    Ext.QuickTips.init();

    Ext.form.Field.prototype.msgTarget = 'side';
    var fa=0;

    var datastore = new Ext.data.JsonStore({
        url:'getcountries',
        root:'countries',
        fields: ['id', 'name'],
    });

    generalForm = new Ext.form.FormPanel({
        bodyStyle: 'padding:5px 5px 0',
        layout:'form',
        frame: true,
        url:'saveProfile',
        defaults: { width:300 },
        title:'Общие сведения',

        items:[{
                // Gender layout {{{
                layout:'column',
                items: [{
                    html:'Пол',
                    width: 110
                },{
                    columnWidth: 0.5,
                    items: [new Ext.form.Radio({name:'gender', inputValue:"1", boxLabel:"Парень"})]
                },{
                    columnWidth: 0.5,
                    items: [new Ext.form.Radio({name:'gender', inputValue:"2", boxLabel:"Девушка"})]
                }] // }}}
        },

            // Form items {{{
            country = new Ext.form.ComboBox({
                fieldLabel: 'Ваша страна',
                id: 'country',
                name: 'country',
                hiddenName: 'data[User][country]',
                displayField: 'name',
                valueField: 'id',
                triggerAction: 'all',
                store: datastore,
                typeAhead:true,
                mode: 'remote',
                emptyText: 'Выберите страну...',
                selectOnFocus:true,
                allowBlank:false,
            }), bornData = new Ext.form.DateField({
                id:'born',
                name:'data[User][born]',
                fieldLabel:'Дата рождения',
                allowBlank: false,
                format:'Y-m-d',
                width:170
            }),new Ext.form.TextField({
                fieldLabel: 'Email',
                inputType: 'text',
                name: 'data[User][email]',
                vtype: 'email',
                allowBlank:false,
                value:email_value
                }),
            {
                html:'<center><img style="margin-left:auto;margin-right:auto;" src="'+avatar_value+'" width="100" height="100"/></center>'
            }, new Ext.form.TextField({
                fieldLabel: 'Аватар',
                name:'data[User][avatar]',
                inputType:'text',
                value:avatar_value
            })// }}}
           ],
        buttons: [{text:"Сохранить", type:"submit", handler:function(){ generalForm.getForm().submit();}}],
    });

    contactsForm = new Ext.form.FormPanel({
        bodyStyle: 'padding:5px 5px 0',
        layout:'form',
        url: 'saveProfile',
        frame: true,
        defaults: { width:300 },
        title:'Контакты',
        defaultType:'textfield',

        items:[{
            fieldLabel: 'ICQ',
            name: 'data[User][icq]',
            value: icq_value
        },{
            fieldLabel: 'Skype',
            name: 'data[User][skype]',
            value: skype_value
        },{
            fieldLabel: 'Yahoo',
            name: 'data[User][yahoo]',
            value: yahoo_value
        },{
            fieldLabel: 'Jabber',
            name: 'data[User][jabber]',
            value: jabber_value
        }],
        buttons:[{text:"Сохранить", type:"submit", handler:function(){ contactsForm.getForm().submit();}}]
    });

    notesForm = new Ext.form.FormPanel({
            title: 'Дополнительная информация',
            url:'saveProfile',
            frame: true,
            layout: 'anchor',
            
            items: [{ 
                xtype:"tinymce", anchor:"100%", hideLabel: true,
                id: 'info', name: 'data[User][info]',
                tinymceSettings:{
                    theme : "advanced",
                    plugins : "bbcode, emotions",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_buttons1 :"bold,italic,underline,undo,redo,emotions,link,unlink,image,forecolor,styleselect,removeformat,cleanup,code",
                    theme_advanced_buttons2 :"",
                    theme_advanced_buttons3 :"",
                    theme_advanced_toolbar_align :"left",
                    theme_advanced_styles : "Code=codeStyle;Quote=quoteStyle",
//                    content_css : "css/bbcode.css",
                    entity_encoding : "raw",
                    add_unload_trigger : false,
                    remove_linebreaks : false,
                    inline_styles : false,
                    convert_fonts_to_spans : false
            }}],

            buttons:[{text:"Сохранить", type:"submit", handler:function(){ 
                            var nf=notesForm.getForm();
                            nf.findField('info').syncValue();
                            nf.submit();
                        }
                    }]
    });

    profileEditor = new Ext.TabPanel({
        renderTo:'profileeditor',
        activeTab: 0,
        frame:true,
        defaults:{autoHeight:true},

        items:[generalForm, contactsForm, notesForm], 
    });

    function getNotes()
    {
        if(!fa){Ext.Ajax.request({url:'getNotes',success:function(r){notesForm.getForm().findField('info').setValue(r.responseText);}});fa=1;}
    }

    generalForm.doLayout();
    datastore.on('load', function() {country.setValue(countryid_value);});
    datastore.load();
    var grb = generalForm.getForm().findField('gender');
    if(gender_value == 1) { grb.setValue("1"); } else if(gender_value == 2) { grb.setValue("2"); }
    bornData.setValue(birth_value);
    notesForm.on('activate', getNotes);
});
