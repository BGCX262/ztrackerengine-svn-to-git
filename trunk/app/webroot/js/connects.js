Ext.onReady(function() {
    var conn_store = new Ext.data.JsonStore({
        url:'/users/getconnects',
        root: 'torrents',
        fields: [
            {name: 'name', type: "string"},
            {name: 'category', type: "string"},
            {name: 'seeders', type: "int"},
            {name: 'leechers', type: "int"}
        ]
    });

    function renderUpload(val, mdata, rec) {
        var tid = rec.get('id');
        var t = val.match("(.+?)/");
        mdata.css = 'center_cell ' + mdata.css;
        return '<a href="/torrents/view/'+tid+'">' + t[1] + '</a>';
    }

    function renderCategory(val, mdata) {
        mdata.css = 'center_cell '+ mdata.css;
        return '<img src="/img/categories/'+val+'"/ height=24>';
    }

    var connect_block = new Ext.grid.GridPanel({
        title:'Активные подключения',
        applyTo:'connect_block',
        collapsible:true,
        collapsed:true,
        autoHeight:true,
        store:conn_store,
        columns: [
            {header: "Категория", width:100, dataIndex: 'category',  renderer:renderCategory, menuDisabled: true},
            {id:"name", header: "Название", width:200, dataIndex: 'name', renderer:renderUpload, sortable: true, menuDisabled: true},
            {header: "Раздают", width:80, dataIndex: 'seeders', sortable: true, menuDisabled: true},
            {header: "Качают", width:80, dataIndex: 'leechers', sortable: true, menuDisabled: true}
                    ],
        autoExpandColumn: 'name',
        stripeRows: true,
    });

    connect_block.on('beforeExpand', getUploads);

    function getUploads() { if(conn_store.getCount() == 0)  { conn_store.load({params:{"user":user_id}}); } }
     
})
