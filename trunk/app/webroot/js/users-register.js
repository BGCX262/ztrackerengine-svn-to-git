Ext.apply(Ext.form.VTypes, {
        password: function(val, field) {
              if(field.initialPassField) {
                   var pwd = Ext.getCmp(field.initialPassField);
                   return (val == pwd.getValue());
              }
              return true;
        },

        passwordText: 'Пароли различаются'
});

Ext.onReady(function() {

    Ext.QuickTips.init();
    
    Ext.form.Field.prototype.msgTarget = 'side';

    var country_store = new Ext.data.JsonStore({
        url:'getcountries',
        root:'countries',
        fields:[{name:'name'},{name:'id'}]
    });
    
    var register_form = new Ext.form.FormPanel({
        title:'Регистрация',
        url:'registersave',
        bodyStyle:'padding:5px 5px 0',
        labelWidth: 100,
        defaultType:'textfield',
        defaults: { width:200 },
        frame:true,
        width:344,

        items: [{
                fieldLabel: 'Логин',
                name: 'data[User][username]',
                allowBlank:false,
                vtype:'alphanum'
            },{
                name:'data[User][sha_hash]',
                id:'password',
                inputType:'hidden'
            },{
                fieldLabel: 'Email',
                name: 'data[User][email]',
                vtype: 'email',
                allowBlank:false
            }, pass1 = new Ext.ux.PasswordMeter({
                fieldLabel:'Пароль',
                id:'pass1',
                name:'pass1',
                width:175,
                inputType:'password',
                allowBlank:false,
                maxLength:20,
                minLength:4
            }),{
                fieldLabel:'Пароль еще раз',
                id:'pass2',
                name:'pass2',
                inputType:'password',
                vtype: 'password',
                initialPassField: 'pass1'
            }, country = new Ext.form.ComboBox({
                fieldLabel: 'Ваша страна',
                id: 'country',
                name: 'country',
                hiddenName: 'data[User][country]',
                displayField: 'name',
                valueField: 'id',
                triggerAction: 'all',
                store: country_store,
                typeAhead:true,
                mode: 'remote',
                emptyText: 'Выберите страну...',
                selectOnFocus:true,
                allowBlank:false
            }), bornData = new Ext.form.DateField({
                id:'born',
                name:'data[User][birthday]',
                fieldLabel:'Дата рождения',
                allowBlank: false,
                format:'Y-m-d',
                width:170
            }), agree = new Ext.form.Checkbox({
                fieldLabel:'Я прочитал(a) <a href="" location="_blank">правила</a>',
                name:'agree',
                id:'agree',
                allowBlank:false
            })
    ],

        buttons: [{
                text: 'Дальше',
                handler: formDataEval,
                type: 'submit'
            },{
                text: 'Отмена',
                handler: (function() {register_form.reset();})
            }]
    });

    register_form.on('actioncomplete', function() { location.reload();});
    register_form.on('actionfailed', function() {
                Ext.MessageBox.alert('Ошибка!', 'Ошибка в процессе регистрации пользователя');
            });

    function formDataEval() {
        var ack = agree.getValue();
        if(!ack) {
            agree.markInvalid("Пожалуста, ознакомтесь с правилами и поставте отметку.");
            Ext.MessageBox.alert("Ошибка","Пожалуста, ознакомтесь с правилами и поставте отметку.");
            register_form.getForm().markInvalid();
            return false;
        }
        if(register_form.getForm().isValid() == true)
        {
            var thisForm = register_form.getForm();
            var passtr = thisForm.findField('pass1').getValue();
            thisForm.findField('password').setValue(Ext.ux.Crypto.SHA1.hash(passtr));
            thisForm.findField('pass1').reset();
            thisForm.findField('pass2').reset();
            thisForm.submit({clientValidation:false});
        } else {
            register_form.getForm().markInvalid();
        }
    }

    register_form.render(document.getElementById('register_form'));

});
