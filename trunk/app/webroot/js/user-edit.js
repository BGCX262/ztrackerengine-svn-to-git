Ext.onReady(function() {
    Ext.BLANK_IMAGE_URL="../img/s.gif";

    var group_store = new Ext.data.JsonStore({
        url: '../getgroups',
        root: 'groups',
        fields:[{name:'id'},{name:'name'}]
    });

    var user_editor = new Ext.form.FormPanel({
        applyTo:'user_editor',
        url: '../modify',
        bodyStyle: 'padding:auto auto auto auto',
        labelWidth: 150,
        defaultType:'textfield',
        height:"300",
        frame:true,

        items:[{
            name:'data[User][id]',
            inputType:'hidden',
            value:uid
        }, {
            fieldLabel: 'Имя пользователя',
            name:'data[User][username]',
            allowblank:false,
            value:username,
        },{
            fieldLabel: 'Надпись',
            name: 'data[User][title]',
            value:title,
        }, group = new Ext.form.ComboBox({
            fieldLabel: 'Группа',
            id: 'group',
            name: 'group',
            hiddenName: 'data[User][group_id]',
            displayField: 'name',
            valueField: 'id',
            triggerAction: 'all',
            store: group_store,
            typeAhead:true,
            mode: 'remote',
            emptyText: 'Выберите группу...',
            selectOnFocus:true,
            allowBlank:false,
            loadingText:"Загрузка групп",
            style:"text-align:left;",
            width:200,
            })
        ],
        
        buttons:[{text:'Сохранить', handler:function(){user_editor.getForm().submit();}}]
    });
    group_store.on('load', function() { group.setValue(group_id); });

    group_store.load();
});
