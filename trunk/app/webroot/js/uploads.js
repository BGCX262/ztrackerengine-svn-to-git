Ext.onReady(function() {
    var store = new Ext.data.JsonStore({
        url:'/users/getuploads',
        root: 'torrents',
        fields: [
            {name: 'id', type: "int"},
            {name: 'name', type: "string"},
            {name: 'category', type: "string"},
            {name: 'completed', type: "int"},
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

    var upload_block = new Ext.grid.GridPanel({
        title:'Раздачи',
        applyTo:'upload_block',
        collapsible:true,
        collapsed:true,
        autoHeight:true,
        store:store,
        columns: [
            {header: "Категория", width:100, dataIndex: 'category',  renderer:renderCategory, menuDisabled: true},
            {id:"name", header: "Название", width:200, dataIndex: 'name', renderer:renderUpload, sortable: true, menuDisabled: true},
            {header: "Скачали", width:80, dataIndex: 'completed', sortable: true, menuDisabled: true},
            {header: "Качают", width:80, dataIndex: 'leechers', sortable: true, menuDisabled: true}
                    ],
        autoExpandColumn: 'name',
        stripeRows: true,
    });

    upload_block.on('beforeExpand', getUploads);

    function getUploads()
    {
        if(store.getCount() == 0)
        {
            store.load({params:{"user":user_id}});
        }
    }
     
})
