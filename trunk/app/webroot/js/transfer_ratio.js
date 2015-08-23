traf = [
    ['1', 'Кб'],
    ['1024', 'Мб'],
    ['1048576','Гб']
];

var store = new Ext.data.SimpleStore({
    fields: ['modifier', 'name'],
    data : traf
});


var transRatioForm = new Ext.form.FormPanel({
    bodyStyle: 'padding:5px 5px 0',
    baseCls: 'x-plain',
    frame: true,
    height: 200,
    labelWidth: 75,
    id: 'transRatioForm',
    url: '../transferRatio',
    defaultType:'textfield',
    defaults: { width:200 },

    items:[{
        fieldLabel: 'Получатель',
        id: 'receiver',
        name: 'receiver',
        vtype:'alphanum',
        allowBlank:false
    },{
        fieldLabel: 'Количество',
        id: 'amount',
        name: 'amount',
        value: '100',
        vtype:'alphanum',
        allowBlank:false,
    }, {
        id: 'amtype',
        name: 'amtype',
        fieldLabel: 'Единицы',
        labelWidth: 75,
        xtype: 'combo',
        store: store,
        displayField:'name',
        valueField:'modifier',
        value:'1024',
        typeAhead: false,
        mode: 'local',
        triggerAction: 'all',
        selectOnFocus:true,
        style:"text-align:left;",
        allowBlank:false,
    }],
});

    transRatioForm.on('actioncomplete', function() { transRatioForm.getForm().findField('amount').setValue(100);});

    var sendTrafWindow = new Ext.Window({
        title: 'Трансфер трафика',
        width: 340,
        height:200,
        minWidth: 300,
        minHeight: 200,
        layout: 'fit',
        closeAction: 'hide',
        plain:true,
        bodyStyle:'padding:5px;',
        buttonAlign:'center',
        items: transRatioForm,

        buttons: [{
            text: 'Подтвердить',
            handler:function() {
                var f = Ext.getCmp('transRatioForm').getForm();
                var amv = f.findField('amount').getValue();
                var amtv = f.findField('amtype').getValue();
                f.findField('amount').setValue(amv * amtv * 1024);
                f.submit();
                sendTrafWindow.hide(); }
        },{
            text: 'Отмена',
            handler:function() {
                var f = Ext.getCmp('transRatioForm').getForm();
                f.reset();
                sendTrafWindow.hide();
             }
        }]
    });
