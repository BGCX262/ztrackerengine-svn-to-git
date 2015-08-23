Ext.onReady(function(){
    var forgotpass_form = new Ext.form.FormPanel({
        url:'',
        defaultType:'textfield',
        labelWidth: 50,
        width: 400,
        baseCls: 'x-box',
        renderTo: 'forgotpass_form',
        bodyStyle: 'padding:5px 5px 0',
        onSubmit: Ext.emptyFn,

        items:[{
            xtype:'label',
            html:'Введите почтовый адрес, которорый Вы использовали при регистрации. На указанный адрес будут высланы иструкции по восстановлению пароля.<br/>'
        },{
            fieldLabel: 'Email',
            name: 'data[User][email]',
            allowBlank: false,
            vtype: 'email',
            width: 310
        }],

        buttons:[{text:"Ок", type:'Submit', handler:function() {forgotpass_form.getForm().getEl().dom.submit();}}]
 
    });

    forgotpass_form.render(document.getElementById('forgotpass_form'));

})
