Ext.onReady(function() {

        var login_form = new Ext.form.FormPanel({
            url:'/users/dologin',
            defaultType:'textfield',
            labelWidth: 50,
            width: 295,
            baseCls: 'x-box',
            renderTo: 'login_form',
            bodyStyle: 'padding:5px 5px 0',

            items: [{
                fieldLabel: 'Логин',
                name: 'data[User][username]',
                allowBlank: false,
                width: 210
            },{
                fieldLabel: 'Пароль',
                name: 'data[User][pass]',
                id: 'pass',
                inputType: 'password',
                width: 210
            },{
                name: 'data[User][password]',
                id: 'password',
                inputType:'hidden'
            },{
                xtype: 'label',
                anchor: '100%',
                html:'<center><a href="#">Напомнить пароль</a></center>'
            }],

            buttons: [{
                text: 'Логин',
                type: 'submit',
                handler: formDataEval
            },{
                text: 'Регистрация',
                handler: function() { window.location = '/users/register'; }
            }]
        });
        
        login_form.on('actioncomplete', function() {location.reload();})

        function formDataEval()
        {
            login_form.getForm().findField('password').setValue(Ext.ux.Crypto.SHA1.hash(login_form.getForm().findField('pass').getValue()));
            login_form.getForm().submit();
        }

        login_form.render(document.getElementById('login_form'));
})
